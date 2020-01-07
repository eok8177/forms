<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsToGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms_to_groups', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('form_id')->index();
			$table->unsignedBigInteger('form_group_id');
			$table->timestamps();
			$table->foreign('form_id')->references('id')->on('forms');
			$table->foreign('form_group_id')->references('id')->on('form_groups');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forms_to_groups');
    }
}
