<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('room_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('label');
            $table->string('thumbnail')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('vendor')->nullable();
            $table->string('model')->nullable();
            $table->integer('replacement_id')->unsigned()->nullable();
            $table->integer('quantity')->unsigned()->nullable();
            $table->string('description')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->string('weber_inventory_tag')->unique()->nullable();
            $table->date('acquisition_date')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('replacement_cost_est')->nullable();
            $table->integer('replacement_fiscal_year')->nullable();
            $table->date('last_audit')->nullable();
            $table->string('po_number')->nullable();
            $table->boolean('checkoutable')->nullable();
            $table->string('category')->nullable();
            $table->integer('lifecycle')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('assets', function (Blueprint $table) {
            // $table->foreign('room_id')->references('id')->on('room');
            // $table->foreign('replacement_id')->references('id')->on('assets');
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');

    }
}
