<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_hewan', function (Blueprint $table) {
            $table->id();
            $table->integer('id_genre')->index();
            $table->string('nama', 55);
            $table->text('keterangan')->nullable();
            $table->string('objek')->nullable();
            $table->string('voice')->nullable();
            $table->text('editor',100)->nullable();
            $table->tinyInteger('vr')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_hewan');
    }
};
