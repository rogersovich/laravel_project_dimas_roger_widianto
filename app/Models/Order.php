<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'tanggal',
        'total',
        'bukti_pembayaran',
        'status_pembayaran',
        'nama_penerima',
        'alamat_pengiriman',
        'telepon',
        'metode_pembayaran',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'tanggal' => 'date',
        'total' => 'decimal:2',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order products for the order.
     */
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * Get the products for the order through order_products.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('jumlah', 'harga_satuan')
            ->withTimestamps();
    }
}
