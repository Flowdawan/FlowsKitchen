<template>
    <ul class="list-inline">
        <li class="height: 220px;  list-inline-item bg-secondary text-white rounded-lg m-2" v-for="meal in meals">
            <div :id="meal.idMeal">
                <img :src="meal.strMealThumb" class="thumbnail">
                <p class="mealTitle">{{meal.strMeal}}</p>
            </div>

            <div class="modal text-dark" :id="meal.idMeal + 'modal'" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{meal.strMeal}}</h5>
                            <button type="button" class="close" :id="meal.idMeal + 'closeSpn'" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <img :src="meal.strMealThumb" class="img-fluid">
                                <div v-html="meal.strIngredients" class="font-italic float-right"></div>
                                <div v-html="meal.strInstructions" class="font-italic"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Add to MyRecipes</button>
                            <button type="button" :id="meal.idMeal + 'closeBtn'" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </li>
        <div id='meals' class="invisible">
            {{url}}
        </div>
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
        }
    },

    methods: {async fetchURL(mealsOrMeal){
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
            await this.fetchURL("meals");
            for(let i = 0; i < this.meals.length; i++) {
                await this.showMeal(this.meals[i].idMeal, i);
                this.createModal(this.meals[i].idMeal);
            }
            this.$forceUpdate();
        },

        async showMeal(id,index){
            this.url_meal = null;
            this.url_meal = "https://www.themealdb.com/api/json/v2/9973533/lookup.php?i=" + id;
            await this.fetchURL("meal");
            let allIngredients = this.getAllIngredients();
            this.meals[index]["strIngredients"] = allIngredients;
            this.meals[index]["strYoutube"] = this.meal.strYoutube;
            this.meals[index]["strInstructions"] = this.meal.strInstructions.replace(/\r\n/g, "<br />");
        },

        getAllIngredients() {
            let ingredients = "<p>";
            let num = 1;
            while(this.meal[`strIngredient${num}`] != "" && this.meal[`strIngredient${num}`] != null )
            {
                ingredients += this.meal[`strMeasure${num}`] + " of " + this.meal[`strIngredient${num}`] + "<br>";
                num++;
            }
            return ingredients + "</p>";
        },

        createModal(id) {
            let modal = document.getElementById(id + "modal");
            let div = document.getElementById(id);
            let closeSpn = document.getElementById(id + "closeSpn");
            let closeBtn = document.getElementById(id + "closeBtn");
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

        }
    },

    watch: {
        url: function () {
            this.showMeals();
        }
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

</style>
