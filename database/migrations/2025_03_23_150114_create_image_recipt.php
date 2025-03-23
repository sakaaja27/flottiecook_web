<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('image_recipt', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipt_id');
            $table->string('image_path');
            $table->timestamps();
            $table->foreign('recipt_id')->references('id')->on('recipt')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('image_recipt');
    }
};
