<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductBahan;
use App\Models\Stock;
use App\Models\Reportbeli;
use App\Models\Reportjual;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    public static function index(){
        return view('main');
    }
    public static function produk(){
        $data = [
            'product' => Product::all(),
            'stock' => Stock::all(),
            'productbahan' => ProductBahan::join(),
            'query' => ''
        ];
        return view('produk', $data);
    }
    public static function bahan(){
        $data = [
            'data' => Stock::all(),
            'query' => ''
        ];
        return view('bahan', $data);
    }
    public static function beli(){
        $data = [
            'data' => Stock::all()
        ];
        return view('beli', $data);
    }
    public static function jual(){
        $data = [
            'data' => Product::all()
        ];
        return view('jual', $data);
    }
    public static function laporan(){
        $date = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
        $data = [
            'reportbeliall' => Reportbeli::whereBetween('created_at', [date('Y-m-d'), $date])->orderBy('created_at', 'desc')->get(),
            'reportjualall' => Reportjual::whereBetween('created_at', [date('Y-m-d'), $date])->orderBy('created_at', 'desc')->get(),
            'reportbeli' => Reportbeli::select(DB::raw('sum(harga*jumlah) as harga'), 'nama', DB::raw('sum(jumlah) as jumlah'), 'satuan')->whereBetween('created_at', [date('Y-m-d'), $date])->groupBy('nama', 'satuan')->orderBy('created_at', 'desc')->get(),
            'reportjual' => Reportjual::select(DB::raw('sum(harga*jumlah) as harga'), 'nama', DB::raw('sum(jumlah) as jumlah'), 'satuan')->whereBetween('created_at', [date('Y-m-d'), $date])->groupBy('nama', 'satuan')->orderBy('created_at', 'desc')->get(),
            'stock' => Stock::all(),
            'sisastok' => DB::select("SELECT nama, (jumlah - (SELECT SUM(jumlah) FROM reportbelis WHERE reportbelis.nama=S.nama AND created_at>'date(Y-m-d)') + (SELECT sum(reportjuals.jumlah * product_bahans.jumlah) AS jumlah FROM product_bahans INNER JOIN products ON product_bahans.produk=products.id INNER JOIN reportjuals ON products.nama=reportjuals.nama INNER JOIN stocks ON stocks.id=product_bahans.bahan WHERE reportjuals.created_at>'date(Y-m-d)' AND stocks.nama=S.nama GROUP BY stocks.nama)) AS jumlah FROM stocks AS S"),
            'perubahanstok' => DB::select("SELECT nama, sum(jumlah) as jumlah FROM ( SELECT nama, sum(jumlah) as jumlah FROM `reportbelis` WHERE created_at>='date(Y-m-d)' AND created_at<='$date' GROUP BY nama UNION ALL SELECT stocks.nama, sum(product_bahans.jumlah*reportjuals.jumlah)*-1 as jumlah FROM `product_bahans` INNER JOIN products on product_bahans.produk=products.id INNER JOIN stocks on product_bahans.bahan=stocks.id INNER JOIN reportjuals on reportjuals.nama=products.nama WHERE reportjuals.created_at>='date(Y-m-d)' AND reportjuals.created_at<='$date' GROUP BY stocks.nama ) as report GROUP BY nama"),
            'query' => 'i'
        ];
        return view('laporan', $data);
        //sisastok=awal+
        // sisa stok = stock>jumlah - reportbeli>jumlah + reportjual>jumlah * productbahan>jumlah
        // perubahan stok = reportbeli>jumlah - reportjual>jumlah * productbahan>jumlah - sisastok
    }
    public static function laporanperiode(Request $data1){
        $data1['tglakhir'] = date('Y-m-d', strtotime($data1['tglakhir'] . ' +1 day'));
        $data = [
            'reportbeliall' => Reportbeli::whereBetween('created_at', [$data1['tglawal'], $data1['tglakhir']])->orderBy('created_at', 'desc')->get(),
            'reportjualall' => Reportjual::whereBetween('created_at', [$data1['tglawal'], $data1['tglakhir']])->orderBy('created_at', 'desc')->get(),
            'reportbeli' => Reportbeli::select(DB::raw('sum(harga*jumlah) as harga'), 'nama', DB::raw('sum(jumlah) as jumlah'), 'satuan')->whereBetween('created_at', [$data1['tglawal'], $data1['tglakhir']])->groupBy('nama', 'satuan')->orderBy('created_at', 'desc')->get(),
            'reportjual' => Reportjual::select(DB::raw('sum(harga*jumlah) as harga'), 'nama', DB::raw('sum(jumlah) as jumlah'), 'satuan')->whereBetween('created_at', [$data1['tglawal'], $data1['tglakhir']])->groupBy('nama', 'satuan')->orderBy('created_at', 'desc')->get(),
            'stock' => Stock::all(),
            'sisastok' => DB::select("SELECT nama, (jumlah - (SELECT SUM(jumlah) FROM reportbelis WHERE reportbelis.nama=S.nama AND created_at>'$data1[tglawal]') + (SELECT sum(reportjuals.jumlah * product_bahans.jumlah) AS jumlah FROM product_bahans INNER JOIN products ON product_bahans.produk=products.id INNER JOIN reportjuals ON products.nama=reportjuals.nama INNER JOIN stocks ON stocks.id=product_bahans.bahan WHERE reportjuals.created_at>'$data1[tglawal]' AND stocks.nama=S.nama GROUP BY stocks.nama)) AS jumlah FROM stocks AS S"),
            'perubahanstok' => DB::select("SELECT nama, sum(jumlah) as jumlah FROM ( SELECT nama, sum(jumlah) as jumlah FROM `reportbelis` WHERE created_at>='$data1[tglawal]' AND created_at<='$data1[tglakhir]' GROUP BY nama UNION ALL SELECT stocks.nama, sum(product_bahans.jumlah*reportjuals.jumlah)*-1 as jumlah FROM `product_bahans` INNER JOIN products on product_bahans.produk=products.id INNER JOIN stocks on product_bahans.bahan=stocks.id INNER JOIN reportjuals on reportjuals.nama=products.nama WHERE reportjuals.created_at>='$data1[tglawal]' AND reportjuals.created_at<='$data1[tglakhir]' GROUP BY stocks.nama ) as report GROUP BY nama"),
            'query' => 'p'
        ];
        return view('laporan', $data);
    }
    use AuthorizesRequests, ValidatesRequests;
}
