<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraBorders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('borders', function (Blueprint $table) {
            $table->boolean('layer_style')->default(0); // 0 = under 1 = over the user icon
            $table->integer('parent_id')->unsigned()->nullable()->default(null);
            $table->boolean('has_layer')->default(0);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('border_variant_id')->unsigned()->nullable()->default(null);
            $table->integer('bottom_border_id')->unsigned()->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('border_variant_id');
            $table->dropColumn('bottom_border_id');
        });
        Schema::table('borders', function (Blueprint $table) {
            $table->dropColumn('layer_style');
            $table->dropColumn('parent_id'); 
        });
    }
}
