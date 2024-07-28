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
        Schema::table('orderesfromemergencystatuses', function (Blueprint $table) {
            // Check if the user_id column exists before adding it
            if (!Schema::hasColumn('orderesfromemergencystatuses', 'user_id')) {
                $table->unsignedBigInteger('user_id');
            }

            // Add foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orderesfromemergencystatuses', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['user_id']);

            // Optionally, drop the user_id column if you want to revert the change completely
            if (Schema::hasColumn('orderesfromemergencystatuses', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
};
