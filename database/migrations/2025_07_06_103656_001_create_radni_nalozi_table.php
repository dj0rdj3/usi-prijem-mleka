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
        Schema::create('radni_nalozi', function (Blueprint $table) {
            $table->id();

            $table
                ->bigInteger('domacinstvo_id')
                ->unsigned()
                ->index();

            $table
                ->bigInteger('rukovodilac_id')
                ->unsigned()
                ->index();

            $table
                ->bigInteger('vozac_id')
                ->unsigned()
                ->index();

            $table
                ->bigInteger('tehnolog_id')
                ->unsigned()
                ->index();

            $table->enum('tip_mleka', ['kravlje', 'kozije', 'ovcije']);

            $table
                ->integer('kolicina_mleka')
                ->unsigned()
                ->nullable();

            $table
                ->decimal('procenat_mm', 3, 1)
                ->unsigned()
                ->nullable();

            $table->boolean('primljeno')->nullable();

            $table->text('komentar')->nullable();

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();

            $table
                ->foreign('rukovodilac_id')
                ->references('id')
                ->on('users');

            $table
                ->foreign('vozac_id')
                ->references('id')
                ->on('users');

            $table
                ->foreign('tehnolog_id')
                ->references('id')
                ->on('users');

            $table
                ->foreign('domacinstvo_id')
                ->references('id')
                ->on('domacinstva');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('radni_nalozi');
    }
};
