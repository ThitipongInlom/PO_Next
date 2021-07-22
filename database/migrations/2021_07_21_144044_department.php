<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Department extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id('department_id');
            $table->string('department_code')->nullable();
            $table->string('department_name_th')->nullable();
            $table->string('department_name_en')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->enum('is_deleted', ['0', '1'])->default('1');
            $table->string('by_deleted')->nullable();
            $table->dateTime('date_deleted', $precision = 0)->nullable();
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
        Schema::dropIfExists('departments');
    }
}
