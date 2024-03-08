<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ControllerProduct extends Controller
{
    public function store(Request $data){
        Product::create($data->all());
        return redirect()->route('product.index');
    }
    public function destroy($id){
        $data = Product::find($id);
        $data->delete();
        return redirect()->route('product.index');
    }
    public function edit($id){
        $data = [
            'data' => Product::find($id),
            'query' => 'editp'
        ];
        return view('produk', $data);
    }
    public function update(Request $data1, $id){
        $data = Product::find($id);
        $data->update($data1->all());
        // $data1->update();
        return redirect()->route('product.index');
    }
}
