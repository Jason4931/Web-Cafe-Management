<div>
    <a href="/">Kembali</a>
    <p><b>Laporan</b></p>
    {{-- Periode: <input type="number" value="1" style="width: 45px" min="0" max="999" required>
    <select required>
        <option>Hari</option>
        <option>Minggu</option>
        <option>Bulan</option>
        <option>Tahun</option>
    </select> --}}
    <form action="/laporanp" method="get">
        Periode: 
        @if (isset($_GET['tglawal']) && isset($_GET['tglakhir']))
            <input name="tglawal" type="date" value="{{ $_GET['tglawal'] }}" required> - <input name="tglakhir" type="date" value="{{ $_GET['tglakhir'] }}" required>
        @else
            <input name="tglawal" type="date" value="{{ date('Y-m-d') }}" required> - <input name="tglakhir" type="date" value="{{ date('Y-m-d') }}" required>
        @endif
        <input type="submit"><br>
        <a href="/laporan">Reset Periode</a>
    </form>
    <table border="1" cellpadding="10">
        <tr><td>
            @if ($query == "i")
                <p>Histori Laporan Penjualan & Pembelian <font color="darkblue">Hari ini</font></p>
            @elseif ($query == "p")
                <p>Histori Laporan Penjualan & Pembelian</p>
            @endif
            <table border="1" style="width: 100%">
                <tr>
                    <th rowspan="2">Action</th>
                    <th colspan="2">Harga</th>
                    <th rowspan="2">Nama</th>
                    <th rowspan="2">Jumlah</th>
                    <th rowspan="2">Satuan</th>
                </tr>
                <tr>
                    <th>Satuan</th>
                    <th>Total</th>
                </tr>
                @foreach ($reportbeliall as $a)
                    <tr>
                        <td>Beli</td>
                        <td>{{ $a->harga }}</td>
                        <td>{{ $a->harga * $a->jumlah }}</td>
                        <td>{{ $a->nama }}</td>
                        <td>{{ $a->jumlah }}</td>
                        <td>{{ $a->satuan }}</td>
                    </tr>
                @endforeach
                @foreach ($reportjualall as $a)
                    <tr>
                        <td>Jual</td>
                        <td>{{ $a->harga }}</td>
                        <td>{{ $a->harga * $a->jumlah }}</td>
                        <td>{{ $a->nama }}</td>
                        <td>{{ $a->jumlah }}</td>
                        <td>{{ $a->satuan }}</td>
                    </tr>
                @endforeach
            </table>
            <p>Laporan Stok Bahan</p>
            <table border="1" cellpadding="5" style="width: 100%">
                <tr><td>
                    <table border="1" style="width: 100%">
                        <tr>
                            <th>Bahan</th>
                            <th>Sisa Stok</th>
                            <th>Perubahan Stok</th>
                        </tr>
                        <?php 
                        $jumlahsisa = 0;
                        foreach ($sisastok as $a) {
                            $jumlahsisa += $a->jumlah;
                        }
                        $jumlahperubahan = 0;
                        foreach ($perubahanstok as $a) {
                            $jumlahsisa += $a->jumlah;
                            $jumlahperubahan += $a->jumlah;
                        }

                        $yesterday = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
                        if(isset($_GET["tglakhir"])) {
                            $date = date('Y-m-d', strtotime($_GET["tglakhir"] . ' +1 day'));
                        }
                        $id=0;
                        ?>
                        @foreach ($stock as $a)
                            <tr>
                                <td>{{ $a->nama }}</td>
                                @if (isset($sisastok[$id]->jumlah) && isset($perubahanstok[$id]->jumlah))
                                    <td>{{ $sisastok[$id]->jumlah + $perubahanstok[$id]->jumlah }} {{ $a->satuan }}</td>
                                @else
                                    <td>0 {{ $a->satuan }}</td>
                                @endif
                                @if (isset($perubahanstok[$id]->jumlah))
                                    <td>{{ $perubahanstok[$id]->jumlah }} {{ $a->satuan }}</td>
                                @else
                                    <td>0 {{ $a->satuan }}</td>
                                @endif
                            </tr>
                            <?php $id++; ?>
                        @endforeach
                    </table>
                    <br>Total Sisa Stok: {{$jumlahsisa}}<br>
                    Total Perubahan Stok: {{$jumlahperubahan}}
                </td></tr>
            </table>
            <p>Laporan Transaksi Penjualan</p>
            <table border="1" cellpadding="5" style="width: 100%">
                <tr><td>
                    <table border="1" style="width: 100%">
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah Penjualan</th>
                            <th>Nilai Penjualan</th>
                        </tr>
                        <?php 
                        $jumlahj = 0;
                        $nilaij = 0;
                        foreach ($reportjual as $a) {
                            $jumlahj += $a->jumlah;
                            $nilaij += $a->harga;
                        }
                        ?>
                        @foreach ($reportjual as $a)
                            <tr>
                                <td>{{ $a->nama }}</td>
                                <td>{{ $a->jumlah }} {{ $a->satuan }}</td>
                                <td>{{ $a->harga }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <br>Total Jumlah Penjualan: {{ $jumlahj }}<br>
                    Total Nilai Penjualan: {{ $nilaij }}<br>
                </td></tr>
            </table>
            <p>Laporan Transaksi Pembelian</p>
            <table border="1" cellpadding="5" style="width: 100%">
                <tr><td>
                    <table border="1" style="width: 100%">
                        <tr>
                            <th>Bahan</th>
                            <th>Jumlah Pembelian</th>
                            <th>Nilai Pembelian</th>
                        </tr>
                        <?php 
                        $jumlahb = 0;
                        $nilaib = 0;
                        foreach ($reportbeli as $a) {
                            $jumlahb += $a->jumlah;
                            $nilaib += $a->harga;
                        }
                        ?>
                        @foreach ($reportbeli as $a)
                            <tr>
                                <td>{{ $a->nama }}</td>
                                <td>{{ $a->jumlah }} {{ $a->satuan }}</td>
                                <td>{{ $a->harga }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <br>Total Jumlah Pembelian: {{ $jumlahb }}<br>
                    Total Nilai Pembelian: {{ $nilaib }}<br>
                </td></tr>
            </table>
            @if ($nilaij - $nilaib >= 0)
                <p>Keuntungan : <font color="darkgreen">+{{ $nilaij - $nilaib }}</font></p>
            @elseif ($nilaij - $nilaib < 0)
                <p>Kerugian : <font color="darkred">{{ $nilaij - $nilaib }}</font></p>
            @endif
        </td></tr>
    </table>
</div>