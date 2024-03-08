<div>
    <a href="/">Kembali</a>
    <p>Produk Yang Tersedia</p>
    <a href="?insertp">Insert Produk Baru</a>
    @if (isset($_GET['insertp']))
        <form method="post" action="{{ route('product.store') }}">
            @csrf
            Nama : <input type="text" name="nama" required><br>
            Harga : <input type="number" name="harga" min="0" required><br>
            Kategori : <input type="text" name="kategori" required><br>
            <input type="submit">
        </form>
    @endif
    @if ($query == '')
        <table border="1">
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th colspan="2">Action</th>
            </tr>
            @foreach ($product as $a)
                <tr>
                    <td>{{ $a->nama }}</td>
                    <td>{{ $a->harga }}</td>
                    <td>{{ $a->kategori }}</td>
                    {{-- {{ var_dump($a) }} --}}
                    <td style="padding-top: 20px">
                        <form method="GET" action="{{ route('product.edit', $a, $a->id) }}">
                            @csrf
                            <input type="submit" value="Update">
                        </form>
                    </td>
                    <td style="padding-top: 20px">
                        <form method="POST" action="{{ route('product.destroy', $a, $a->id) }}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                    {{-- <td><a href="{{ route('product.destroy', $a->id) }}">Delete</a></td> --}}
                </tr>
            @endforeach
        </table>
    @elseif ($query == 'editp')
        <form method="post" action="{{ route('product.update', $data, $data->id) }}">
            @csrf
            @method('PUT')
            Nama : <input type="text" name="nama" value="{{ $data->nama }}" required><br>
            Harga : <input type="number" name="harga" value="{{ $data->harga }}"required><br>
            Kategori : <input type="text" name="kategori" value="{{ $data->kategori }}"required><br>
            <input type="submit">
        </form>
    @endif
    <p>Bahan-Bahan Yang Diperlukan</p>
    <a href="?insertpb">Insert Bahan Baru</a>
    @if (isset($_GET['insertpb']))
        <form method="post" action="{{ route('productbahan.store') }}">
            @csrf
            Produk : <select name="produk" style="width: 177px">
                @foreach ($product as $a)
                    <option value="{{ $a->id }}">{{ $a->nama }}</option>
                @endforeach
            </select><br>
            Bahan : <select name="bahan" style="width: 177px">
                @foreach ($stock as $a)
                    <option value="{{ $a->id }}">{{ $a->nama }}</option>
                @endforeach
            </select><br>
            Jumlah : <input type="number" name="jumlah" min="0" required><br>
            Satuan : <input type="text" name="satuan"><br>
            <input type="submit">
        </form>
    @endif
    @if ($query == '')
        <table border="1">
            <tr>
                <th>Produk</th>
                <th>Bahan</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th colspan="2">Action</th>
            </tr>
            @foreach ($productbahan as $a)
                <tr>
                    <td>{{ $a->namap }}</td>
                    <td>{{ $a->namas }}</td>
                    <td>{{ $a->jumlah }}</td>
                    <td>{{ $a->satuan }}</td>
                    {{-- {{ var_dump($a) }} --}}
                    <td style="padding-top: 20px">
                        <form method="GET" action="{{ route('productbahan.edit', $a, $a->id) }}">
                            @csrf
                            <input type="submit" value="Update">
                        </form>
                    </td>
                    <td style="padding-top: 20px">
                        <form method="POST" action="{{ route('productbahan.destroy', $a, $a->id) }}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @elseif ($query == 'editpb')
        <form method="post" action="{{ route('productbahan.update', $data, $data->id) }}">
            @csrf
            @method('PUT')
            Produk : <select name="produk" style="width: 177px">
                @foreach ($product as $a)
                    @if ($data->produk == $a->id)
                        <option value="{{ $a->id }}" selected>{{ $a->nama }}</option>
                    @else
                        <option value="{{ $a->id }}">{{ $a->nama }}</option>
                    @endif
                @endforeach
            </select><br>
            Bahan : <select name="bahan" style="width: 177px" value="{{ $data->bahan }}">
                @foreach ($stock as $a)
                    @if ($data->bahan == $a->id)
                        <option value="{{ $a->id }}" selected>{{ $a->nama }}</option>
                    @else
                        <option value="{{ $a->id }}">{{ $a->nama }}</option>
                    @endif
                @endforeach
            </select><br>
            Jumlah : <input type="number" name="jumlah" value="{{ $data->jumlah }}" min="0" required><br>
            Satuan : <input type="text" name="satuan" value="{{ $data->satuan }}"><br>
            <input type="submit">
        </form>
    @endif
</div>