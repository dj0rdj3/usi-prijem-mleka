<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReseedDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:reseed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reseed database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $tables = DB::select('SHOW TABLES');
        $tableKey = 'Tables_in_' . DB::getDatabaseName();

        foreach ($tables as $table) {
            $tableName = $table->$tableKey;
            if ($tableName === 'migrations') continue;

            DB::table($tableName)->truncate();
            $this->info("Truncated: $tableName");
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call('db:seed');
        $this->info('Database reseeded.');
    }
}
