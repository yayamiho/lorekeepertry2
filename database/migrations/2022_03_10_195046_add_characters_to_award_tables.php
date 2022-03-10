<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCharactersToAwardTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('awards', function (Blueprint $table) {
            // Add Release code a la Mercury
            $table->boolean('is_released')->default(1);
            $table->boolean('allow_transfer')->default(1);
        });

        // If someone wants to take on the idea of award tags on their own, go ahead. I'm not doing it anytime soon. - Uri :)
        Schema::dropIfExists('award_tags');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('awards', function (Blueprint $table) {
            // Add Release code a la Mercury
            $table->dropColumn('is_released');
            $table->dropColumn('allow_transfer');
        });

        Schema::create('award_tags', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('award_id')->unsigned();
            $table->string('tag')->index();

            $table->text('data')->nullable()->default(null);
            $table->boolean('is_active')->default(0);
        });

    }
}
