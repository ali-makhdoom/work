<?php

namespace App\Listeners;

use App\Events\DuplicateProductFound;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\DuplicateProductNotification;

class SendDuplicateProductEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\DuplicateProductFound  $event
     * @return void
     */
 
    
    public function handle(DuplicateProductFound $event)
    {
        $sku = $event->sku;
    
        Mail::to(auth()->user()->email)->send(new DuplicateProductNotification($sku));
    }
}
