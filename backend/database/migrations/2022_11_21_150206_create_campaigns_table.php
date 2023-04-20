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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->bigInteger('budget');
            $table->bigInteger('bid_amount');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('banner');
            $table->string('final_url')->nullable();
            $table->integer('user_id')->nullable();
            $table->bigInteger('used_amount')->nullable();
            $table->double('usage_rate')->nullable();
            $table->integer('status')->default(1);
            $table->integer('is_deleted')->default(0);
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
        Schema::dropIfExists('campaigns');
    }
};
