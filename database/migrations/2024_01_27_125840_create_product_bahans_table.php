<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_bahans', function (Blueprint $table) {
            $table->id();
            $table->string('produk');
            $table->string('bahan');
            $table->double('jumlah');
            $table->string('satuan');
            $table->timestamps();
        });
        // Schema::table('product_bahans', function (Blueprint $table) {
        //     $table->foreign('produk')->references('id')->on('products');
        //     $table->foreign('bahan')->references('id')->on('stocks');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_bahans');
    }
};
