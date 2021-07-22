<?php

namespace App\Console\Commands;

use App\Models\CampaignGasto;
use Illuminate\Console\Command;

class MigrateInfluencerIdToArrayIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'influencers:change-influencer-id-type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para cambiar tipo de dato campo influencer id';

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
        CampaignGasto::query()->select('influencer_id','id')
            ->cursor()
            ->each(function(CampaignGasto $campaignGasto){
                $campaignGasto->influencer_id = [$campaignGasto->influencer_id];
                $campaignGasto->save();
        });
    }
}
