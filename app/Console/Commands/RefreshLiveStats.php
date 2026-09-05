<?php

namespace App\Console\Commands;

use App\Models\SiteInfo;
use Illuminate\Console\Command;

class RefreshLiveStats extends Command
{
    protected $signature = 'stats:refresh';
    protected $description = 'Refresh all predefined site statistics from live DB counts (every 24h)';

    public function handle(): int
    {
        $updated = SiteInfo::refreshLiveStats();
        $this->info("Live stats refreshed. Updated rows: {$updated}");
        return Command::SUCCESS;
    }
}
