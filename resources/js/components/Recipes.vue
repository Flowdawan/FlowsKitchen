<template>
    <ul class="list-inline">
        <p class="display: none; text-center text-white" id="noRecipes">There are no saved recipes</p>
        <li class="list-inline-item bg-secondary text-white rounded-lg m-2" v-for="meal in meals">
            <div :id="meal.idMeal + 'thumbnail'" class="mealResults">
                <img :src="meal.strMealThumb" class="thumbnail  rounded-lg">
                <p class="mealTitle text-truncate">{{meal.strMeal}}</p>
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
                            <div class="container-fluid" id="modalContent">
                                <div id="picturesModal">
                                <img :src="meal.strMealThumb" class="img-fluid float-left" id="modalImg">
                                <iframe id="youtube" width="350" height="360"
                                        :src="meal.strYoutube">
                                </iframe>
                                </div>
                                <div class="text-center" id="textModal">
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
                document.getElementById("noRecipes").style.display = "none";
            } else {
                document.getElementById("noRecipes").style.display = "block";
            }

        },

        async showMeals(){
            document.getElementById("loadingWheel").style.display = "block";
            for(let i = 0; i < this.meals.length; i++) {
                await this.showMeal(i);
                this.createModal(this.meals[i].idMeal);
            }
            document.getElementById("loadingWheel").style.display = "none";
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
            let removeBtn = document.getElementById(id);

            div.onclick = function() {
                modal.style.display = "block";
            }
            closeSpn.onclick = function() {
                modal.style.display = "none";
            }
            closeBtn.onclick = function() {
                modal.style.display = "none";
            }
            removeBtn.onclick = function () {
                modal.style.display = "none";
            }
        },

        async deleteRecipe(){
            await axios.delete("/recipes", {
                data: {
                    recipeId: event.currentTarget.id,
                }
            });

            this.meals.splice(0,this.meals.length);
            this.recipes.splice(0,this.recipes.length);
            await this.getRecipesFromUser();
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

#picturesModal {

}

#textModal {

}

.thumbnail {
    grid-column: 1 / 3;
    grid-row: 1;

    width: 100%;
    height: auto;
}

.mealTitle {
    grid-column: 1 / 3;
    grid-row: 2;

    margin-bottom: 4px;

    text-shadow: -2px 0 black, 0 2px black, 2px 0 black, 0 -2px black;
    font-family: sans-serif; color: white;
    font-size: 18px;
}

ul {
    margin: 15px 15% 50px 15%;
}

li {
    width: 18%;
    position: relative;
    border-color: white 1px;
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

@media screen and (max-width: 800px) {
    .modal {
        position: fixed;
        margin-left: 50px;
        width: 400px;
        height: 500px;
    }
    #youtube {
        position: relative;
        width: 155px;
        height: 155px;
    }
    .loader{
        position:fixed;
        top:25%;
        left:30%;
        width: 150px;
        height: 150px;
    }

    .mealTitle{
        width: 260px;
    }

    li {
        width: auto;
    }

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

@media screen and (max-width: 780px) {
    li {
        width: auto;
    }
}
</style>
