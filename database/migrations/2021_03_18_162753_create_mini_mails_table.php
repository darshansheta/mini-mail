<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiniMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mini_mails', function (Blueprint $table) {
            $table->id();
            $table->string('from')->index();
            $table->string('to')->index();
            $table->string('subject');
            $table->string('status')->index();
            $table->datetime('sent_at')->nullable();
            $table->mediumText('html_content');
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
        Schema::dropIfExists('mini_mails');
    }
}
