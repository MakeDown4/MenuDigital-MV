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
        if (!Schema::hasTable('menu_items')) {
            Schema::create('menu_items', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('description');
                $table->decimal('price', 8, 2);
                $table->timestamps();
            });
    
            Schema::table('menu_items', function (Blueprint $table) {
                $table->unsignedBigInteger('category_id')->after('price');
                $table->foreign('category_id')->references('id')->on('menu_categories')->onDelete('set null');
            });
        }
    }
    
    public function down()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    
        Schema::dropIfExists('menu_items');
    }    
}
