<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->text('pickup_place');
            $table->dateTime('start_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('end_date')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('pickup_place');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
        });
    }
};
