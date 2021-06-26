<template>
    <ul class="list-inline">
        <li class="height: 220px;  list-inline-item bg-secondary text-white rounded-lg m-2" v-for="meal in meals">
            <div :id="meal.idMeal" v-on:click="showMeal">
                <img :src="meal.strMealThumb" class="thumbnail">
                <p class="mealTitle">{{meal.strMeal}}</p>
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
            let targetId = event.currentTarget.id;
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
