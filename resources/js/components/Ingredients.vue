<template>
    <form autocomplete="off" id="searchMealsForm" @submit.prevent="searchMeals">
        <div class="justify-content-lg-center row row-cols-sm-2">
            <div class="bg-white p-3 rounded-lg col-md-4 text-center">
                <p>Zutaten:</p>
                <div class="autocomplete" style="width:300px;">
                    <input style="width:300px;" id="myInput" type="myInput" placeholder="Ingredient"
                           name="ingredient" v-model="ingredient"><br>
                </div>
            </div>
        </div>
        <div><br></div>
        <div class="d-flex justify-content-center align-items-center">
            <input class="btn btn-outline-success sendButton" type="submit">
        </div>
        <meals :url="url" />
    </form>
</template>

<script>
import ac from "../autocomplete.js";
import Meals from "./Meals.vue";
export default {

    components: {
        Meals
    },

    name: "Ingredients",

    data() {
        return {
            meals: [],
            ingredients: [],
            ingredient: '',
            url: ''
        }
    },

    methods: {
        searchMeals: function () {
            this.ingredient = document.getElementById("myInput").value;
            let url = 'https://www.themealdb.com/api/json/v2/9973533/filter.php?i=' + this.ingredient;
            this.url = url.replace(" ","_");
            console.log(this.url);
        },

        autoComplete: function () {
            ac.autocomplete(document.getElementById("myInput"), this.ingredients);
        },

        getAllIngredients: function () {
            fetch('https://www.themealdb.com/api/json/v2/9973533/list.php?i=list', {
                method: 'get'})
                .then(response => response.json())
                .then(json => {
                    this.ingredients = json.meals.map(a => a.strIngredient);
                });
        }

    },

    created() {
        this.getAllIngredients();
    },

    updated() {
        this.autoComplete();
    },

}
</script>

<style scoped>
.autocomplete {
    /*the container must be positioned relative:*/
    position: relative;
    display: inline-block;
}

.autocomplete-items {
    position: absolute;
    border: 1px solid #d4d4d4;
    border-bottom: none;
    border-top: none;
    z-index: 99;
    /*position the autocomplete items to be the same width as the container:*/
    top: 100%;
    left: 0;
    right: 0;
}

.autocomplete-items div {
    padding: 10px;
    cursor: pointer;
    background-color: #fff;
    border-bottom: 1px solid #d4d4d4;
}

.autocomplete-items div:hover {
    /*when hovering an item:*/
    background-color: #e9e9e9;
}

.autocomplete-active {
    /*when navigating through the items using the arrow keys:*/
    background-color: DodgerBlue !important;
    color: #ffffff;
}
</style>
