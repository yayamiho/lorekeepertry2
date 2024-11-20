<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteDesignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_design', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('design'); //eg. headerless, squished...

            $table->string('heading_font_family');
            $table->integer('heading_letter_spacing');
            $table->string('heading_text_transform');
            $table->string('heading_font_weight');

            $table->string('navigation_font_family');
            $table->integer('navigation_letter_spacing');
            $table->string('navigation_text_transform');
            $table->string('navigation_font_weight');

            $table->string('sidebar_font_family');
            $table->integer('sidebar_letter_spacing');
            $table->string('sidebar_text_transform');
            $table->string('sidebar_font_weight');

            $table->string('body_font_family');
            $table->integer('body_letter_spacing');
            $table->string('body_text_transform');
            $table->string('body_font_weight');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_design');
    }
}
