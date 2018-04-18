<?php

namespace App\Console\Commands;

use App\Jobs\ProcessUserDesiredRule;
use App\Models\User;
use Illuminate\Console\Command;

class RunProcessUserDesiredRuleJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process-user-desired-rule:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run user desired rule job';
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new command instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = $this->user->where('rule_id', '!=', null)
                            ->where('instagram_access_token', '!=', null)
                            ->get();

        foreach ($users as $user) {
            ProcessUserDesiredRule::dispatch($user);
        }

        return true;
    }
}
