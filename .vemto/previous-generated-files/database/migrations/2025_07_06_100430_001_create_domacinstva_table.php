<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domacinstva', function (Blueprint $table) {
            $table->id();

            $table->string('naziv', 255);

            $table->string('adresa', 255);

            $table->string('koordinate', 255);

            $table->set('tipovi_mleka', ['kravlje', 'kozije', 'ovcije']);

            $table
                ->bigInteger('user_id')
                ->unsigned()
                ->index();

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domacinstva');
    }
};
