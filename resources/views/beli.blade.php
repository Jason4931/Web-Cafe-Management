<div>
    <p>Pembelian Bahan</p>
    <a href="/">Kembali</a><br><br>
    <form action="/reportbeli" method="get">
        @csrf
        <table cellspacing="0" cellpadding="0" style="margin-bottom: 3px">
            <tr>
                <td>Nama:⠀</td>
                <td>
                    <select name="nama" style="width: 100%">
                        @foreach ($data as $a)
                            <option value="{{ $a->nama }}">{{ $a->nama }}</option>
                        @endforeach
                    </select>
                </td>
                <td><font color="red">*</font></td>
            </tr>
            <tr>
                <td>Harga/Satuan:⠀</td>
                <td><input name="harga" type="number" min="0" required></td>
                <td><font color="red">*</font></td>
            </tr>
            <tr>
                <td>Jumlah:⠀</td>
                <td><input name="jumlah" type="number" min="0" required></td>
                <td><font color="red">*</font></td>
            </tr>
            <tr>
                <td>Satuan:⠀</td>
                <td><input name="satuan" type="text"></td>
            </tr>
        </table>
        <input type="submit">
    </form>
</div>
