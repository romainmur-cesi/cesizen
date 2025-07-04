<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ShowTablesStructure extends Command
{
    protected $signature = 'db:show-structure';
    protected $description = 'Afficher la structure des tables de la base de données';

    public function handle(): void
    {
        $tables = DB::select('SELECT name FROM sqlite_master WHERE type="table" AND name NOT LIKE "sqlite_%"');

        foreach ($tables as $tableObj) {
            $table = $tableObj->name;
            $this->info("🔹 Table: $table");

            $columns = Schema::getColumnListing($table);
            foreach ($columns as $column) {
                $type = Schema::getColumnType($table, $column);
                $this->line("    - $column ($type)");
            }

            $this->line(str_repeat('-', 40));
        }
    }
}
