<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_type')->nullable()->comment('Plugin, theme, core,...');
            $table->string('project_slug')->nullable()->comment('Name/slug of the project.');
            $table->string('locale')->nullable()->comment('Translation locale.');
            $table->text('comment')->nullable();
            $table->text('msgctxt')->nullable();
            $table->text('msgid')->nullable();
            $table->text('msgid_plural')->nullable();
            $table->text('msgstr')->nullable();
            $table->text('msgstr0')->nullable();
            $table->text('msgstr1')->nullable();
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
        Schema::dropIfExists('translations');
    }
}
