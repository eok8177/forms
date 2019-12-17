<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSettingsToForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->tinyInteger('shedule')->nullable()->default(0);
            $table->text('start_date')->nullable();
            $table->text('end_date')->nullable();
            $table->tinyInteger('login_only')->nullable()->default(0);
            $table->mediumText('confirm_text')->nullable();
            $table->text('redirect_url')->nullable();
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
            $table->dropColumn(['shedule']);
            $table->dropColumn(['start_date']);
            $table->dropColumn(['end_date']);
            $table->dropColumn(['login_only']);
            $table->dropColumn(['confirm_text']);
            $table->dropColumn(['redirect_url']);
        });
    }
}
