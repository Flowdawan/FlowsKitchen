@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <form autocomplete="off" action="index.php">
        <div class="justify-content-lg-center row row-cols-sm-2">
            <div class="bg-white p-3 rounded-lg col-md-4 text-center">
                Enter an ingredient here:<br>
                <div class="autocomplete" style="width:300px;">
                    <input type="myInput" style="width:300px;" id="myInput" type="text" placeholder="Ingredient"
                           name="ingredient"><br>
                </div>
            </div>
        </div>
        <div><br></div>
        <div class="d-flex justify-content-center align-items-center">
            <input class="btn btn-outline-success sendButton" type="submit">
        </div>

    </form>
    <style>
        .results {
            width: 300px;
            height: 300px;
            border: black 2px;
        }

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

        img.thumbnail {
            width: 100px;
            height: 70px;
        }
    </style>

    <?php
    //echo json_encode($json);
    $curl = curl_init();
    // set our apiCall-url with curl_setopt()
    curl_setopt($curl, CURLOPT_URL, "https://www.themealdb.com/api/json/v2/9973533/list.php?i=list");

    // return the json as a string, also with setopt()
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    // curl_exec() executes the started curl session
    // $output contains the output string
    $output = curl_exec($curl);
    // js_decode() turns into json again for testing
    $json = json_decode($output);

    foreach ($json->meals as $item) {
        $ingredients[] = $item->strIngredient;
    }
    ?>

    <script>
        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function (e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function (e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function (e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }

            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });
        }

        /*An array containing all the recipe names from mealDB:*/
        var ingredients = <?php echo json_encode($ingredients); ?>;
        /*initiate the autocomplete function on the "myInput" element, and pass along the recipes array as possible autocomplete values:*/
        autocomplete(document.getElementById("myInput"), ingredients);
    </script>

    <?php
    /**
     * Erst müssen wir mit /filter.php?i=ingredient1,ingredient2,ingredient3,....
     * nach Gerichte suchen die unseren Zutatenfilter entsprechen
     * wir erhalten Name, Bild und ID vom essen, das Reicht für das Thumbnail.
     * Beim Klicken vom Thumbnail müssen wir dann mit folgenden
     * /lookup.php?i=52772 nach Details über Gericht fragen (Zubereitung,...)
     * und können dann im größeren Fenster das Gericht anzeigen.
     */
    $jsonRecipes = array();
    $jsonNames = array();
    $jsonImages = array();
    if (!empty($_GET["ingredient"])) {
        //create url base
        $searchIngredient = str_replace(" ", "_", $_GET["ingredient"]);
        $urlBase = "https://www.themealdb.com/api/json/v2/9973533/filter.php?i=";
        $urlBase .= $searchIngredient;

        // create & initialize a curl session
        $curl = curl_init();

        // set our apiCall-url with curl_setopt()
        curl_setopt($curl, CURLOPT_URL, $urlBase);

        // return the json as a string, also with setopt()
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // curl_exec() executes the started curl session
        // $output contains the output string
        $output = curl_exec($curl);

        // json_decode() turns into json again for testing
        $jsonRecipes = json_decode($output);

        // check if json is not empty
        if ($jsonRecipes->meals != null) {
            //save the meal names and thumbnails in arrays
            foreach ($jsonRecipes->meals as $item) {
                $jsonImages[] = $item->strMealThumb;
                $jsonNames[] = $item->strMeal;
                //adding meal+thumbnails to html
                echo "<br>";
                echo '<div class="width: 300px; height: 300px; col-md-2 offset-md-5 bg-secondary text-white d-flex justify-content-center rounded-lg"> <img src="';
                echo $item->strMealThumb;
                echo '" class="thumbnail"><p>';
                echo $item->strMeal;
                echo '</p></div><br>';
            }
        } else {
            //if json is empty try with v1 of mealDB
            $urlBase = "https://www.themealdb.com/api/json/v1/1/filter.php?i=";
            $urlBase .= $searchIngredient;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $urlBase);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            $jsonRecipes = json_decode($output);
            if ($jsonRecipes->meals != null) {
                foreach ($jsonRecipes->meals as $item) {
                    $jsonImages[] = $item->strMealThumb;
                    $jsonNames[] = $item->strMeal;
                    echo "<br>";
                    echo '<div class="width: 300px; height: 300px; col-md-2 offset-md-5 bg-secondary text-white d-flex justify-content-center rounded-lg"> <img src="';
                    echo $item->strMealThumb;
                    echo '" class="thumbnail"><p>';
                    echo $item->strMeal;
                    echo '</p></div><br>';
                }
            }
        }


        echo '<div><br></div><div><br></div><div><br></div>';

        // close curl resource to free up system resources
        // (deletes the variable made by curl_init)
        curl_close($curl);
    }
    ?>
    <script>
        function resultRecipes() {
            <?php echo "start resultRecipes()" ?>
            var results = <?php echo json_encode($jsonRecipes); ?>;
            var resultsName = <?php echo json_encode($jsonNames); ?>;
            var resultsImg = <?php echo json_encode($jsonImages); ?>;
            if (results != null) {
                for (let i = 0; i < results.length; i++) {

                    let result = document.createElement("div");
                    result.setAttribute("class", "results");


                    let resultName = document.createElement("p");
                    let tmp1 = resultsName[i];
                    let resultNameText = document.createTextNode(tmp1)
                    resultName.appendChild(resultNameText);


                    let resultImg = document.createElement("img");
                    let tmp2 = resultsImg[i];
                    resultImg.setAttribute("src", tmp2);
                    resultImg.setAttribute("height", "200");
                    resultImg.setAttribute("width", "200");

                    document.getElementById("rezepte").appendChild(result);
                    document.getElementById("result").appendChild(resultName);
                    document.getElementById("result").appendChild(resultImg);
                }

            }

        }
    </script>
@endsection

