<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductBahan;
use App\Models\Stock;
use Illuminate\Http\Request;

class ControllerProductBahan extends Controller
{
    public function store(Request $data){
        ProductBahan::create($data->all());
        return redirect()->route('productbahan.index');
    }
    public function destroy($id){
        $data = ProductBahan::find($id);
        $data->delete();
        return redirect()->route('productbahan.index');
    }
    public function edit($id){
        $data = [
            'data' => ProductBahan::find($id),
            'product' => Product::all(),
            'stock' => Stock::all(),
            'query' => 'editpb'
        ];
        return view('produk', $data);
    }
    public function update(Request $data1, $id){
        $data = ProductBahan::find($id);
        $data->update($data1->all());
        return redirect()->route('productbahan.index');
    }
}