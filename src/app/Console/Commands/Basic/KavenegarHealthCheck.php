<?php

namespace App\Console\Commands\Basic;

use App\Models\Basic\User;
use App\Notifications\Basic\KavenegarHealthCheckNotification;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class KavenegarHealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'healthCheck:Kavenegar {mobile}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $mobile = $this->argument('mobile');

        $user = User::getUserByMobile($mobile);

        if (!$user) {
            $this->error("No user found with mobile number " . $mobile);

            return CommandAlias::FAILURE;
        }

        $this->info('Kavenegar notification sent to user ' . $mobile);

        $user->notify(new KavenegarHealthCheckNotification());

        return CommandAlias::SUCCESS;
    }
}
