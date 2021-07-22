<?php

namespace App\Console\Commands;

use App\Mail\Alerts\ExpiringAlert;
use App\Models\Alert;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotificationAlertDue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:notification-to-due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Script para notificar que una alerta esta por vencer.';

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
        Alert::with('influencer')->latest()->get()->each(function(Alert $alert){
            if( $alert->isDueToExpire() ){
                $users = User::canSentNotifications(Alert::class,'expiringAlert')->getAllActives()->get();
                Mail::to($users)->send( new ExpiringAlert($alert) );
            }
        });
    }
}
