<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('form_id');
            $table->string('type'); // user_submit | user_accept | user_reject | admin_submit | manager_submit
            $table->string('from_name')->nullable();
            $table->string('from_email')->nullable();
            $table->string('send_to')->nullable();
            $table->string('subject')->nullable();
            $table->mediumText('message')->nullable();
            $table->tinyInteger('active')->default(0);
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
        Schema::dropIfExists('form_emails');
    }
}
