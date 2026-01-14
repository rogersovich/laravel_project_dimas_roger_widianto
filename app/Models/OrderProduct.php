<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'jumlah',
        'harga_satuan',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'harga_satuan' => 'decimal:2',
    ];

    /**
     * Get the order that owns this order product.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product for this order product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
