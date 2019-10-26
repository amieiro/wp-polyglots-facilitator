<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToStatistics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statistics', function (Blueprint $table) {
            $table->integer('translated')->after('number_contributors')->nullable();
            $table->integer('untranslated')->after('translated')->nullable();
            $table->integer('fuzzy')->after('untranslated')->nullable();
            $table->integer('waiting')->after('fuzzy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statistics', function (Blueprint $table) {
            $table->dropColumn('translated');
            $table->dropColumn('untranslated');
            $table->dropColumn('fuzzy');
            $table->dropColumn('waiting');
        });
    }
}
