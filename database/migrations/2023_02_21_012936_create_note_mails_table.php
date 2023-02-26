<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoteMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_mails', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_reccured')->default(FALSE);
            $table->string('name', 240);
            $table->string('interval', 230)->nullable();
            $table->text('content')->nullable();
            $table->foreignId('project_id')->constrained('note_mails')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('note_mails');
    }
}
