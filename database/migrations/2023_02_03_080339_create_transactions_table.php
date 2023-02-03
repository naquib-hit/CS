<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('trans_date');
            $table->string('invoice_no', 40);
            $table->date('create_date');
            $table->date('date_send')->nullable();
            $table->date('due_date')->nullable();
            $table->smallInteger('delivery_status')->default(0);
            $table->json('details');
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}