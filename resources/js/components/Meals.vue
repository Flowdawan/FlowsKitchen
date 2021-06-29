<template>
    <ul class="list-inline">
        <li class="height: 220px;  list-inline-item bg-secondary text-white rounded-lg m-2" v-for="meal in meals">
            <div :id="meal.idMeal + 'thumbnail'">
                <img :src="meal.strMealThumb" class="thumbnail">
                <p class="mealTitle">{{meal.strMeal}}</p>
            </div>
            <div class="modal text-dark" :id="meal.idMeal + 'modal'" tabindex="-1" role="dialog">
                <div class="modal-dialog-scrollable modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{meal.strMeal}}</h5>
                            <button type="button" class="close" :id="meal.idMeal + 'closeSpn'" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <img :src="meal.strMealThumb" class="img-fluid float-left" id="modalImg">
                                <iframe width="350" height="360"
                                        :src="meal.strYoutube">
                                </iframe>
                                <div class="text-center">
                                    <div v-html="meal.strIngredients" class="font-italic"></div>
                                    <div v-html="meal.strInstructions"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" :id="meal.idMeal" v-on:click="bookmark">Add to MyRecipes</button>
                            <button type="button" :id="meal.idMeal + 'closeBtn'" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <div id='meals' class="invisible">
            {{url}}
        </div>
        <div class="loader" id="loadingWheel"></div>
    </ul>

</template>

<script>
export default {
    name: "Meals",

    props: ['url'],

    data() {
        return {
            meal: null,
            meals: [],
            url_meal: null,
            bookmarkedMealId: null,
        }
    },

    methods: {
        async fetchURL(mealsOrMeal){
            if(mealsOrMeal == "meals") {
                const response = await fetch(this.url);
                const json = await response.json();
                this.meals = json.meals;
            } else if(mealsOrMeal == "meal"){
                const response = await fetch(this.url_meal);
                const json = await response.json();
                this.meal = null;
                this.meal = json.meals[0];
            }
        },

        async showMeals(){
            document.getElementById("loadingWheel").style.display = "block";
            await this.fetchURL("meals");
            for(let i = 0; i < this.meals.length; i++) {
                await this.showMeal(this.meals[i].idMeal, i);
                this.createModal(this.meals[i].idMeal);
            }
            await this.$forceUpdate();
            document.getElementById("loadingWheel").style.display = "none";
        },

        async showMeal(id,index){
            this.url_meal = null;
            this.url_meal = "https://www.themealdb.com/api/json/v2/9973533/lookup.php?i=" + id;
            await this.fetchURL("meal");
            let allIngredients = this.getAllIngredients();
            this.meals[index]["strIngredients"] = allIngredients;
            this.meals[index]["strYoutube"] = this.meal.strYoutube.replace("/watch?v=", "/embed/");
            this.meals[index]["strInstructions"] = this.meal.strInstructions.replace(/\n/g,'<br>');
        },

        getAllIngredients() {
            let ingredients = "<p>";
            let num = 1;
            while(this.meal[`strIngredient${num}`] != "" && this.meal[`strIngredient${num}`] != null )
            {
                if(this.meal[`strMeasure${num}`] != "" && this.meal[`strMeasure${num}`] != null){
                    ingredients += this.meal[`strMeasure${num}`] + " " + this.meal[`strIngredient${num}`] + "<br>";
                    num++;
                } else {
                    ingredients += this.meal[`strIngredient${num}`] + "<br>";
                    num++;
                }

            }
            return ingredients + "</p>";
        },

        createModal(id) {
            let modal = document.getElementById(id + "modal");
            let div = document.getElementById(id + "thumbnail");
            let closeSpn = document.getElementById(id + "closeSpn");
            let closeBtn = document.getElementById(id + "closeBtn");
            let addBtn = document.getElementById(id);

            if(window.auth_user != "notLoggedIn") {
                addBtn.style.display = "block";
                this.userId = window.auth_user.id;
            } else {
                addBtn.style.display = "none";
            }
            div.onclick = function() {
                modal.style.display = "block";
            }
            closeSpn.onclick = function() {
                modal.style.display = "none";
            }
            closeBtn.onclick = function() {
                modal.style.display = "none";
            }
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        },

        bookmark(){
            axios.post('/recipes', {
                recipeId: event.currentTarget.id
            });

            //console.log("TESTBOOKMARK ID: " + event.currentTarget.id);
            this.bookmarkedMealId = event.currentTarget.id;
        }
    },

    watch: {
        url: function () {
            this.showMeals();
        },
    }
}
</script>

<style scoped>

ul {
    margin: 15px 15%;

}

li {
    width: 18%;
    position: relative;
    border-color: white 1px;
}

p.mealTitle {
    width: 100%;
    position: absolute;
    bottom: 0;
    text-shadow: -2px 0 black, 0 2px black, 2px 0 black, 0 -2px black;
    font-family: sans-serif; color: white;
    font-size: 26px;
}

img.thumbnail {
    width: 100%;
    height: 140px;
}

.modal {
    margin-left: 25%;
    margin-right: 25%;
}

#modalImg {
    max-width: 50%;
    height: auto;
}

.loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 360px;
    height: 360px;
    -webkit-animation: spin 2s linear infinite; /* Safari */
    animation: spin 2s linear infinite;

    position:fixed;
    top:25%;
    left:40%;
    transform:translate(-50%, -50%);
    z-index: 1000;

    display: none;
}

/* Safari */
@-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
