<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id(); //auto ingrement with primary key
            //$table->integer('user_id')->unsigned()->index(); we use the foreignId option

            //onDelete is important to cascade over all the saved recipes when a user get's deleted
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); //laravel itself refers this to the users table and then user_id
            $table->text('recipeId');
            $table->timestamps(); //created at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
