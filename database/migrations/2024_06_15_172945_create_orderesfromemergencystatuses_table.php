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
        Schema::create('orderesfromemergencystatuses', function (Blueprint $table) {
          $table->id();
         $table->unsignedBigInteger('charities_id')->nullable();

        $table->text('description');
        $table->string('first_name');
        $table->string('last_name');
        $table->text('phone');
        $table->text('gender');
       $table->date('birthday');
        $table->text('address');
        $table->json('needs');
       $table->enum('status', ['Pending', 'Completed', 'Cancelled']); // Define the possible statuses here
       $table->foreign('charities_id')->references('id')->on('charities')->onDelete('cascade');

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
        Schema::dropIfExists('orderesfromemergencystatuses');
    }
};
