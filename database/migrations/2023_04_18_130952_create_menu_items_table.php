<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('menu_categories')) {
            Schema::create('menu_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }
        
        if (!Schema::hasTable('menu_items')) {
            Schema::create('menu_items', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description');
                $table->decimal('price', 10, 2);
                $table->foreignId('category_id')->constrained('menu_categories');
                $table->timestamps();
            });
        }
    }
    
    public function down()
    {
        Schema::dropIfExists('menu_items', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('menu_categories');
        });
        Schema::dropIfExists('menu_items');
    }    
}
