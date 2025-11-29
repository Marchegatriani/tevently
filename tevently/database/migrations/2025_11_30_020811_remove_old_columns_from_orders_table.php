<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveOldColumnsFromOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hapus column lama yang sudah pindah ke order_items
            if (Schema::hasColumn('orders', 'ticket_id')) {
                $table->dropForeign(['ticket_id']);
                $table->dropColumn('ticket_id');
            }
            if (Schema::hasColumn('orders', 'quantity')) {
                $table->dropColumn('quantity');
            }
            if (Schema::hasColumn('orders', 'total_tickets')) {
                $table->dropColumn('total_tickets');
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('ticket_id')->nullable()->after('event_id');
            $table->integer('quantity')->after('ticket_id')->default(1);
            $table->integer('total_tickets')->after('quantity')->default(1);
        });
    }
}