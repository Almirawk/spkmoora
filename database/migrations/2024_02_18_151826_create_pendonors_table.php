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
        Schema::create('pendonors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('alamat');
            $table->date('tgl_lahir');
            $table->enum('jns_kelamin', ['L', 'P']); // L untuk laki-laki, P untuk perempuan
            $table->string('no_telepon');
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendonors');
    }
};
