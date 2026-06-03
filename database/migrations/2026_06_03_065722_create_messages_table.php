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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->index();
            $table->unsignedBigInteger('owner_id');
            $table->string('title', 150)->nullable();
            $table->text('body');
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('owner_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->index();
            $table->foreignId('user_id')->index();
            $table->foreignId('message_id')->index();
            $table->integer('is_seen')->default(1);
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('recipients');
    }
};
