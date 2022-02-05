<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LocTracker\LocTrackerService;

class StoreActiveShipments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'active-shipments:store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This commands stores all active shipments';

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
     * @return void
     */
    public function handle(LocTrackerService $locTracker)
    {
        $this->info('Storing active shipments');
        $locTracker->saveActiveShipments();
        $this->info('Done storing active shipments');

    }
}
