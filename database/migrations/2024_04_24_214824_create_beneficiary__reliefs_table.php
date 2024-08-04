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
        Schema::create('beneficiary__reliefs', function (Blueprint $table) {
          $table->id();
         $table->unsignedBigInteger('beneficiaries_id');
         $table->unsignedBigInteger('reliefs_id');
         $table->unsignedBigInteger('charities_id')->nullable();
         $table->enum('status', ['pending', 'approved', 'rejected', 'transformed', 'completed'])->default('pending')->nullable();
         $table->boolean('active')->default(false)->nullable();
         $table->timestamps();

         $table->foreign('beneficiaries_id')->references('id')->on('beneficiaries')->onDelete('cascade');
         $table->foreign('reliefs_id')->references('id')->on('reliefs')->onDelete('cascade');
         $table->foreign('charities_id')->references('id')->on('charities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beneficiary__reliefs');
    }
};
