<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ButtonState;
use Carbon\Carbon;

class DeleteOldButtonStates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'button-states:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '古いボタン状態のデータを削除する';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $yesterday = Carbon::yesterday()->toDateString();

        // 昨日以前のデータを削除
        $deleted = ButtonState::where('date', '<', $yesterday)->delete();

        $this->info("Deleted $deleted old button state records.");
    }
}
