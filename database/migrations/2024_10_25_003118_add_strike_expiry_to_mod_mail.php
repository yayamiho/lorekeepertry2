<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('mod_mails', function (Blueprint $table) {
            //
            $table->timestamp('strike_expiry')->nullable()->default(null)->after('strike_count');
            $table->boolean('has_expired')->default(false)->after('strike_expiry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('mod_mails', function (Blueprint $table) {
            //
            $table->dropColumn('strike_expiry');
            $table->dropColumn('has_expired');
        });
    }
};
