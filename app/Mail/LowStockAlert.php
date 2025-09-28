<?php

namespace App\Mail;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LowStockAlert extends Mailable
{
    use Queueable, SerializesModels;

    public Warehouse $warehouse;
    public Product $product;
    /**
     * Create a new message instance.
     */
    public function __construct($warehouse_id, $product_id)
    {
        $this->warehouse = Warehouse::find($warehouse_id);
        $this->product = Product::find($product_id);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Low Stock Alert',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.low-stock-alert',
        );
    }
}
