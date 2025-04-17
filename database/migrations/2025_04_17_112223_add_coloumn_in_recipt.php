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
        Schema::table('recipt', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->after('id')->nullable();
            $table->foreign('category_id')->references('id')->on('recipes_category')->onDelete('cascade');
            $table->text('ingredient')->after('category_id')->nullable();
            $table->text('tools')->after('ingredient')->nullable();
            $table->text('instruction')->after('tools')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipt', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('ingredient');
            $table->dropColumn('tools');
            $table->dropColumn('instruction');
            $table->dropColumn('category_id');
        });
    }
};
