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
        Schema::create('form_timbangan', function (Blueprint $table) {
            $table->string('id_form')->primary();
            $table->date('tanggal');
            $table->integer('nik');
            $table->string('batch');
            $table->integer('po');
            $table->integer('kd_material');
            $table->decimal('weight', 7, 2);
            $table->integer('dibuat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_timbangan');
    }
};
