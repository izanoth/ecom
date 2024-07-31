<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\Question;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class createAdmin extends Command
{
    protected $signature = 'admin:create';
    protected $description = 'Cria um novo usuário com prompts para username, senha e email';

    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle()
    {
        // Verifica se as migrações foram executadas
        if (!$this->migrationsExecuted()) {
            $this->info('As migrações ainda não foram executadas.');

            if ($this->confirm('Você deseja executar as migrações agora? [y/N]')) {
                try {
                    $this->info('Executando migrações...');
                    Artisan::call('migrate');
                    $this->info('Migrações executadas com sucesso!');
                } catch (\Exception $e) {
                    $this->error('Ocorreu um erro ao executar as migrações: ' . $e->getMessage());
                    return 1;
                }
            } else {
                $this->error('O comando foi cancelado porque as migrações não foram executadas.');
                return 1;
            }
        }

        $questionHelper = new QuestionHelper();
        $username = $this->ask('Nome de usuário');
        $email = $this->ask('E-mail');

        // Solicita a senha sem mostrá-la no terminal
        $password = $this->secret('Senha');

        // Valida os inputs
        $this->validateInputs($username, $email, $password);

        // Cria o usuário
        $user = Admin::create([
            'name' => $username,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Usuário criado com sucesso!');
    }

    protected function migrationsExecuted()
    {
        if (Schema::hasTable('migrations')) {
            return DB::table('migrations')->count() > 0;
        }
        else {
            return false;
        }
    }

    protected function validateInputs($username, $email, $password)
    {
        if (empty($username) || empty($email) || empty($password)) {
            $this->error('Todos os campos são obrigatórios.');
            exit(1);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('O e-mail fornecido não é válido.');
            exit(1);
        }
    }
}
