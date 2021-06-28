<template>
    <ul class="list-inline">
        <li class="height: 220px;  list-inline-item bg-secondary text-white rounded-lg m-2" v-for="meal in meals">
            <div :id="meal.idMeal" v-on:click="showMeal">
                <img :src="meal.strMealThumb" class="thumbnail">
                <p class="mealTitle">{{meal.strMeal}}</p>
            </div>

            <div class="modal" :id="meal.idMeal + 'modal'" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-dark">{{meal.strMeal}}</h5>
                            <button type="button" class="close" :id="meal.idMeal + 'closeSpn'" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img :src="meal.strMealThumb" class="imgMeal">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Save changes</button>
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
            meals: [],
            url: ''
        }
    },

    methods: {

        showMeals(){
            fetch(this.url)
                .then(response => response.json())
                .then(json => {
                    this.meals = json.meals;
                    if(json.meals == null) {
                        this.url = this.url.replace("https://www.themealdb.com/api/json/v2/9973533/filter.php?i=","https://www.themealdb.com/api/json/v1/1/filter.php?i=")
                        fetch(this.url)
                            .then(response => response.json())
                            .then(json => {
                                this.meals = json.meals;
                            });
                    }
                });
        },

        showMeal(){
            this.url_meal = null;
            this.url_meal = "https://www.themealdb.com/api/json/v2/9973533/lookup.php?i=" + event.currentTarget.id;
            fetch(this.url_meal)
                .then(response => response.json())
                .then(json => {
                    this.meal = json.meals[0];
                });

            let modal = document.getElementById(event.currentTarget.id + "modal");
            let div = document.getElementById(event.currentTarget.id);
            let closeSpn = document.getElementById(event.currentTarget.id + "closeSpn");
            let closeBtn = document.getElementById(event.currentTarget.id + "closeBtn");
            setTimeout(() => { console.log(this.meal.strMeal); }, 250);
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

            /*this.getRecipe(this.meal);*/

        }


    },

    updated () {
        this.showMeals();
        console.log("MEALS.VUE: " + this.url);
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
