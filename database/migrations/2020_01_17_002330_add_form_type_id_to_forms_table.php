<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFormTypeIdToFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forms', function (Blueprint $table) {
			$table->unsignedBigInteger('form_type_id')->after('is_trash');
			
			$table->foreign('form_type_id')->references('id')->on('form_types')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forms', function (Blueprint $table) {
			$table->dropForeign(['form_type_id']);
			$table->dropColumn(['form_type_id']);
        });
	}
	
}
