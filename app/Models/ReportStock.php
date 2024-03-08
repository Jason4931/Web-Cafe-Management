<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportStock extends Model
{
    static public function store(Request $data){
        Product::create($data->all());
    }
}
