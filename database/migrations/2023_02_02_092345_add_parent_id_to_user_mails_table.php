<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentIdToUserMailsTable extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        if (!Schema::hasColumn('user_mails', 'parent_id')) {
            Schema::table('user_mails', function (Blueprint $table) {
                $table->integer('parent_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        Schema::table('user_mails', function (Blueprint $table) {
            $table->dropColumn('parent_id');
        });
    }
}
