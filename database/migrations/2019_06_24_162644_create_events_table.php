<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->enum('type' , ['yearly', 'monthly' , 'daily' , 'hourly' , 'exact']);
            $table->date('date');
            $table->dateTime('remind_at');
            $table->string('remind_time');
            $table->bigInteger('person_id');
            $table->bigInteger('user_id');
			$table->longText('extra')->nullable();
			$table->dateTime('last_send_at');
			$table->enum('status' , [0,1])->default(1);
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
        Schema::dropIfExists('events');
    }
}
