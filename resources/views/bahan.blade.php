<div>
    <a href="/">Kembali</a>
    <p>Bahan/Stock Yang Tersedia</p>
    <a href="?insert">Insert Bahan Baru</a>
    @if (isset($_GET['insert']))
        <form method="post" action="{{ route('stock.store') }}">
            @csrf
            Nama : <input type="text" name="nama" required><br>
            Jumlah : <input type="number" name="jumlah" required><br>
            Satuan : <input type="text" name="satuan" required><br>
            <input type="submit">
        </form>
    @endif
    @if ($query == '')
        <table border="1">
            <tr>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th colspan="2">Action</th>
            </tr>
            @foreach ($data as $a)
                <tr>
                    <td>{{ $a->nama }}</td>
                    <td>{{ $a->jumlah }}</td>
                    <td>{{ $a->satuan }}</td>
                    <td style="padding-top: 20px">
                        <form method="GET" action="{{ route('stock.edit', $a, $a->id) }}">
                            @csrf
                            <input type="submit" value="Update">
                        </form>
                    </td>
                    <td style="padding-top: 20px">
                        <form method="POST" action="{{ route('stock.destroy', $a, $a->id) }}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @elseif ($query == 'edit')
        <form method="post" action="{{ route('stock.update', $data, $data->id) }}">
            @csrf
            @method('PUT')
            Nama : <input type="text" name="nama" value="{{ $data->nama }}" required><br>
            Jumlah : <input type="number" name="jumlah" value="{{ $data->jumlah }}"required><br>
            Satuan : <input type="text" name="satuan" value="{{ $data->satuan }}"required><br>
            <input type="submit">
        </form>
    @endif
</div>