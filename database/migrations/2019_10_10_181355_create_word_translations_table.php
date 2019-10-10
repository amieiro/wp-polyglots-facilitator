<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('word_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('source_locale_code')->nullable();
            $table->string('destination_locale_code')->nullable();
            $table->string('source_word')->nullable();
            $table->string('destination_word')->nullable();
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
        Schema::dropIfExists('word_translations');
    }
}
