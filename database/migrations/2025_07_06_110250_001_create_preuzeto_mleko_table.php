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
        Schema::create('preuzeto_mleko', function (Blueprint $table) {
            $table->id();

            $table
                ->bigInteger('radni_nalog_id')
                ->unsigned()
                ->index();

            $table->string('ime_rukovodioca', 255)->nullable();

            $table->string('telefon_rukovodioca', 15)->nullable();

            $table->string('ime_vozaca', 255)->nullable();

            $table->string('telefon_vozaca', 15)->nullable();

            $table->string('ime_tehnologa', 255)->nullable();

            $table->string('telefon_tehnologa', 15)->nullable();

            $table->string('ime_domacina', 255)->nullable();

            $table->string('telefon_domacina', 15)->nullable();

            $table->string('naziv_domacinstva', 255)->nullable();

            $table->string('adresa_domacinstva', 255)->nullable();

            $table->enum('tip_mleka', ['kravlje', 'kozije', 'ovcije'])->nullable();

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

            $table
                ->foreign('radni_nalog_id')
                ->references('id')
                ->on('radni_nalozi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preuzeto_mleko');
    }
};
