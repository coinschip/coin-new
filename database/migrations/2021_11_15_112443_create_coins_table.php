<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->id();
			$table->text('name');
			$table->text('symbol');
			$table->decimal('price', $precision = 8, $scale = 2);
			$table->decimal('yesterday', $precision = 8, $scale = 2); // Should periodically update
			$table->unsignedBigInteger('capital');
			$table->timestamp('launched_at');
			$table->foreignId('user_id');
			$table->string('logo_path', 2048)->nullable();
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
        Schema::dropIfExists('coins');
    }
}
