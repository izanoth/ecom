<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class migrateDown extends Command
{
    protected $signature = 'migrate:down';
    protected $description = 'Drop tables';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if ($this->confirm('Isso excluirá todas as tableas, você tem certeza? [y/N]')) {
            
            {
                $this->info('Iniciando a remoção de tabelas criadas pelas migrações...');
        
                // Obtém a lista de todas as tabelas
                $tables = DB::select('SHOW TABLES');
                $tables = array_map(function ($table) {
                    return array_values((array) $table)[0];
                }, $tables);
        
                // Obtém a lista de tabelas criadas pelas migrações
                $migratedTables = DB::table('migrations')->pluck('table');
        
                // Remove apenas as tabelas registradas nas migrações
                foreach ($tables as $tableName) {
                    if ($migratedTables->contains($tableName)) {
                        try {
                            $this->info("Removendo tabela: $tableName");
                            Schema::dropIfExists($tableName);
                            $this->info("Tabela $tableName removida com sucesso!");
                        } catch (\Exception $e) {
                            $this->error("Erro ao remover tabela $tableName: " . $e->getMessage());
                        }
                    }
                }
        
                $this->info('Tabelas criadas pelas migrações foram removidas.');
            }
        } else {
            $this->error('Cancelado.');
            return 1;
        }
    }

    protected function getMigrationClassName($file)
    {
        $filename = pathinfo($file, PATHINFO_FILENAME);
        return 'App\\Database\\Migrations\\' . $this->toClassName($filename);
    }

    protected function toClassName($filename)
    {
        $filename = str_replace('_', ' ', $filename);
        $filename = ucwords($filename);
        return str_replace(' ', '', $filename);
    }
}
