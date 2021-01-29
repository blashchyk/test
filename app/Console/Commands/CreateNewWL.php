<?php

namespace App\Console\Commands;

use App\Services\WhitelabelCreator\Contracts\WhitelabelCreatorManagerInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CreateNewWL extends Command
{
    protected $signature = 'create_new_wl';
    protected $description = 'Command description';
    protected $whitelabelCreatorManager;

    public function __construct(WhitelabelCreatorManagerInterface $whitelabelCreatorManager)
    {
        parent::__construct();
        $this->whitelabelCreatorManager = $whitelabelCreatorManager;
    }

    public function handle()
    {
        $input = json_decode(Storage::disk('public')->get('config.json'));
        $this->info($this->whitelabelCreatorManager->createACloneOfTheSite((array)$input));
    }
}
