<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class ControllerStock extends Controller
{
    public function store(Request $data){
        Stock::create($data->all());
        return redirect()->route('stock.index');
    }
    public function destroy($id){
        $data = Stock::find($id);
        $data->delete();
        return redirect()->route('stock.index');
    }
    public function edit($id){
        $data = [
            'data' => Stock::find($id),
            'query' => 'edit'
        ];
        return view('bahan', $data);
    }
    public function update(Request $data1, $id){
        $data = Stock::find($id);
        $data->update($data1->all());
        return redirect()->route('stock.index');
    }
    static public function plus($angka, $id){
        $stock = Stock::find($id);
        $stock->jumlah += $angka;
        $stock->save();
    }
    static public function min($angka, $id){
        $stock = Stock::find($id);
        $stock->jumlah -= $angka;
        $stock->save();
    }
}
