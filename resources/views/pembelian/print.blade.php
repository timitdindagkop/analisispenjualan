<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
<body>
    <style type="text/css">
        body{
        font-family: sans-serif;
        }
        table{
        margin: 20px auto;
        border-collapse: collapse;
        }
        table th,
        table td{
        border: 1px solid #3c3c3c;
        padding: 3px 8px;
        }
        .tengah{
            text-align: center;
        }
    </style>
    <h2 class='tengah'>Pembelian Barang</h2>
    <h3 class='tengah'>Pembelian barang di {{ $pembelian->suplier->nama_perusahaan }}</h3>
    <p class='tengah'>Tertanggal : {{ date('d/m/Y', strtotime($pembelian->tanggal)) }}</p>
    <br/>
    <table>
        <tr>
            <th width="5%">No</th>
            <th width="25%">Kode barang</th>
            <th width="25%">Nama barang</th>
            <th width="10%">Jumlah</th>
            <th width="20%">Harga</th>
            <th width="20%">Nominal</th>
        </tr>
        @foreach ($detail_pembelian as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->barang->kode_barang }}</td>
                <td>{{ $item->barang->nama_barang }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($item->harga*$item->jumlah, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5" style="text-align: right"><strong>Total</strong></td>
            <td><strong>Rp. {{ number_format($pembelian->total_uang,0,',','.') }}</strong></td>
        </tr>
    </table>
    <p style="margin-left: 68%">{{ auth()->user()->name }}</p>
    <br><br><br><br>
    <p style="margin-left: 65%">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p>
</body>
<script>
    print()
</script>
</html>
