<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductBahan extends Model
{
    use HasFactory;
    protected $fillable = [
        'produk',
        'bahan',
        'jumlah',
        'satuan',
    ];
    static function join() {
        $users = ProductBahan::select('product_bahans.*', 'products.nama as namap', 'stocks.nama as namas')
            ->join('products', 'product_bahans.produk', '=', 'products.id')
            ->join('stocks', 'product_bahans.bahan', '=', 'stocks.id')
            ->get();
        return $users;
    }
}
