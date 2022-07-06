<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            // Barcode
            $table->string('serial_number')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignId('type_id')->constrained('type');
            $table->enum('status', ['baru', 'normal', 'rusak'])->default('baru');
            $table->date('purchase_date')->nullable();
            $table->date('warranty_date')->nullable();
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
        Schema::dropIfExists('hardware');
    }
}