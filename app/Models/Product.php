<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kategori_id',
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'foto',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'harga' => 'decimal:2',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    /**
     * Accessor for the product image url.
     */
    public function getFotoUrlAttribute(): string
    {
        return $this->foto
            ? Storage::disk('public')->url($this->foto)
            : asset('assets/img/avatars/1.png');
    }
}

