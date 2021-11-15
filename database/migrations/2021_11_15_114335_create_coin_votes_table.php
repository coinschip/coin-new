<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_votes', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->foreignId('coin_id');
			$table->foreignId('user_id')->nullable();
			$table->string('ip_address', 45)->nullable();
			$table->text('user_agent')->nullable();
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coin_votes');
    }
}
