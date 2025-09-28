<x-mail::message>
# Low Stock Alert

Dear Warehouse Manager,

The following product is running low on stock:

- **Warehouse:** {{ $warehouse->name }}
- **Product Name:** {{ $product->name }}
- **SKU:** {{ $product->sku }}

Please take the necessary actions to replenish the stock.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
