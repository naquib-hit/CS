<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('invoice_id')->unique()->constrained('invoices')->cascadeOnUpdate()->cascadeOnDelete();
            $table->double('total_summary');
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('invoice_summaries');
    }
}