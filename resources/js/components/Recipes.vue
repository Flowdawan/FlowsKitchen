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
                            <button type="button" class="btn btn-primary" :id="meal.idMeal" v-on:click="deleteRecipe">Remove from MyRecipes</button>
                            <button type="button" :id="meal.idMeal + 'closeBtn'" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <div class="loader" id="loadingWheel"></div>
    </ul>
</template>

<script>
export default {
    name: "Recipes",

    data() {
        return {
            recipes: [],
            meals: [],
            delete: null,
        }
    },


    methods: {

        async getRecipesFromUser(){
            await axios.get('recipes/api').then(response => this.recipes = response.data);
        },

        async getMeals(){
            console.log("RecipesLength: " + this.recipes.length);
            for(let i = 0; i < this.recipes.length; i++) {
                let urlMeal = "https://www.themealdb.com/api/json/v2/9973533/lookup.php?i=";
                urlMeal += this.recipes[i].recipeId;
                console.log("RecipesURL Nr " + i + " " + urlMeal);

                await fetch(urlMeal, {
                    method: 'get'})
                    .then(response => response.json())
                    .then(json => {
                        this.meals[i] = json.meals[0]
                    });
            }

            this.$forceUpdate();
            if(this.meals.length > 0){
                await this.showMeals();
            }

        },

        async showMeals(){
            document.getElementById("loadingWheel").style.display = "block";
            for(let i = 0; i < this.meals.length; i++) {
                await this.showMeal(i);
                this.createModal(this.meals[i].idMeal);
            }

        },

        showMeal(index){
            this.meals[index]["strIngredients"] = this.getAllIngredients(index);
            this.meals[index].strYoutube = this.meals[index].strYoutube.replace("/watch?v=", "/embed/");
            this.meals[index].strInstructions = this.meals[index].strInstructions.replace(/\n/g,'<br>');
        },

        getAllIngredients(index) {
            let ingredients = "<p>";
            let num = 1;
            while(this.meals[index][`strIngredient${num}`] != "" && this.meals[index][`strIngredient${num}`] != null )
            {
                if(this.meals[index][`strMeasure${num}`] != "" && this.meals[index][`strMeasure${num}`] != null){
                    ingredients += this.meals[index][`strMeasure${num}`] + " " + this.meals[index][`strIngredient${num}`] + "<br>";
                    num++;
                } else {
                    ingredients += this.meals[index][`strIngredient${num}`] + "<br>";
                    num++;
                }
            }
            return ingredients + "</p>";
        },

        createModal(id) {
            this.$forceUpdate();
            let modal = document.getElementById(id + "modal");
            let div = document.getElementById(id + "thumbnail");
            let closeSpn = document.getElementById(id + "closeSpn");
            let closeBtn = document.getElementById(id + "closeBtn");

            document.getElementById("loadingWheel").style.display = "none";
            div.onclick = function() {
                modal.style.display = "block";
            }
            closeSpn.onclick = function() {
                modal.style.display = "none";
            }
            closeBtn.onclick = function() {
                modal.style.display = "none";
            }
        },

        deleteRecipe(){
            axios.delete("/recipe", {
                data: {
                    recipeId: event.currentTarget.id,
                }
            });
        },


    },

    created() {
        this.getRecipesFromUser();
    },

    watch: {
        recipes: function () {
            this.getMeals();
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
