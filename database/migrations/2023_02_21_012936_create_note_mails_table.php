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
            $table->boolean('is_reccured', 120)->default(FALSE);
            $table->string('interval', 230)->nullable();
            $table->text('content')->nullable();
            $table->string('to', 230)->nullable();
            $table->string('from', 230)->nullable();
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
        Schema::dropIfExists('note_mails');
    }
}
