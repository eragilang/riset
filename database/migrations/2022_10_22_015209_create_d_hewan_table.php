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
        Schema::create('d_hewan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_hewan');
            $table->string('nama', 55);
            $table->text('keterangan')->nullable();
            $table->string('objek')->nullable();
            $table->string('voice')->nullable();
            $table->text('editor')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('id_hewan')
                ->references('id')
                ->on('m_hewan')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_hewan');
    }
};
