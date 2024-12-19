<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('surveys', function (Blueprint $table) {
        $table->string('image')->nullable(); // Allows the image column to be null initially
    });
}

public function down()
{
    Schema::table('surveys', function (Blueprint $table) {
        $table->dropColumn('image');
    });
}

};