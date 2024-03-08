<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Reportbeli;
use App\Models\Reportjual;
use App\Http\Controllers\ControllerStock;
use App\Models\ProductBahan;

class ControllerReport extends Controller
{
    public function storebeli(Request $data){
        if($data['satuan'] == ""){
            $satuan = Stock::where('nama', $data['nama'])->get(['satuan']);
            $data['satuan'] = $satuan[0]['satuan'];
        }
        Reportbeli::create($data->all());
        $id = Stock::where('nama', $data['nama'])->get(['id']);
        ControllerStock::plus($data['jumlah'], $id[0]['id']);
        return redirect()->route('stock.index');
    }
    public function storejual(Request $data){
        $kategori = Product::where('nama', $data['nama'])->get(['kategori']);
        if($kategori[0]['kategori'] == "Makanan"){
            $data['satuan'] = "Piring";
        }elseif($kategori[0]['kategori'] == "Minuman"){
            $data['satuan'] = "Gelas";
        }
        if($data['harga'] == ""){
            $harga = Product::where('nama', $data['nama'])->get(['harga']);
            $data['harga'] = $harga[0]['harga'];
        }
        $no=true;
        $idproduk = Product::where('nama', $data['nama'])->value('id');
        $id = ProductBahan::where('produk', $idproduk)->get(['bahan', 'jumlah']);
        foreach ($id as $a) {
            $jumlah = $data['jumlah'] * $a['jumlah'];
            $jumlahbahan = Stock::where('id', $a['bahan'])->value('jumlah');
            if($jumlahbahan-$jumlah >= 0) {
                ControllerStock::min($jumlah, $a['bahan']);
            } else {
                $no=false;
                break;
            }
        }
        if($no) {
            Reportjual::create($data->all());
            return redirect()->route('product.index');
        }
    }
}
