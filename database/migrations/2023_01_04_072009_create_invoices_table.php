<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('invoice_no', 40)->nullable();
            $table->string('po_no')->nullable();
            $table->date('create_date')->useCurrent();
            $table->date('due_date')->nullable();
            $table->date('next_date')->nullable();
            $table->string('discount_amount', 100)->nullable();
            $table->string('discount_unit', 100)->nullable();
            $table->text('notes')->nullable();
            $table->smallInteger('invoice_status')->default(0);
            $table->smallInteger('is_reccuring')->default(0);
            $table->string('currency', 10)->nullable();
            $table->string('frequency', 120)->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}