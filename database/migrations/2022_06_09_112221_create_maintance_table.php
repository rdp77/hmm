<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mtbf_id')->nullable();
            $table->bigInteger('mttr_id')->nullable();
            $table->foreignId('hardware_id')->constrained('hardware');
            $table->foreignId('mt_id')->constrained('mt_dt');
            $table->double('availability');
            $table->foreignId('dependency')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('maintance');
    }
}