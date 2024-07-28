<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameStatisticsCounters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('websockets_statistics_entries', function (Blueprint $table) {
            // Add new columns first
            $table->integer('peak_connections_count')->after('app_id');
            $table->integer('websocket_messages_count')->after('peak_connections_count');
            $table->integer('api_messages_count')->after('websocket_messages_count');
        });

        Schema::table('websockets_statistics_entries', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn('peak_connection_count');
            $table->dropColumn('websocket_message_count');
            $table->dropColumn('api_message_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('websockets_statistics_entries', function (Blueprint $table) {
            // Add old columns back
            $table->integer('peak_connection_count')->after('app_id');
            $table->integer('websocket_message_count')->after('peak_connection_count');
            $table->integer('api_message_count')->after('websocket_message_count');
        });

        Schema::table('websockets_statistics_entries', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn('peak_connections_count');
            $table->dropColumn('websocket_messages_count');
            $table->dropColumn('api_messages_count');
        });
    }
}
