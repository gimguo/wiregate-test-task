<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use MeiliSearch\Client;

class ConfigureMeilisearch extends Command
{
    protected $signature = 'scout:configure-meilisearch';
    protected $description = 'Configure filterable attributes for Meilisearch indexes';

    public function handle()
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $client->index('devices')->updateFilterableAttributes(['health_status']);
        $this->info('Meilisearch "devices" index configured successfully!');

        return 0;
    }
}
