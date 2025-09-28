<?php

namespace App\Listeners;

use App\Events\LowStock;
use Illuminate\Support\Facades\Mail;

class SendMailNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LowStock $event): void
    {
        Mail::to('admin@email.com')->send(new \App\Mail\LowStockAlert($event->stock->warehouse_id, $event->stock->product_id));
    }
}
