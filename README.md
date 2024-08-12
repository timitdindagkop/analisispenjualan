<div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="card-body">
            <h4>Nilai Perhitungan</h4>
            <div class="table-responsive">
                <table id="penjualan" class="table table-bordered mb-0">
                    <thead>
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th width="15%">X</th>
                            <th width="15%">Y</th>
                            <th width="20%">X2</th>
                            <th width="20%">Y2</th>
                            <th width="25%">XY</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualan as $item)
                        <tr class="text-center">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item['no'] }}</td>
                            <td>{{ $item['penjualan'] }}</td>
                            <td>{{$item['no'] * $item['no']}}</td>
                            <td>{{ $item['penjualan']*$item['penjualan'] }}</td>
                            <td>{{ $item['no']*$item['penjualan'] }}</td>
                        </tr>
                        <?php $totalno += $loop->iteration; ?>
                        <?php $totalx += $item['no']; ?>
                        <?php $totaly += $item['penjualan']; ?>
                        <?php $totalx2 += $item['no']*$item['no']; ?>
                        <?php $totaly2 += $item['penjualan'] * $item['penjualan']; ?>
                        <?php $totalxy += $item['no'] * $item['penjualan']; ?>
                    @endforeach
                    <tr class="text-center">
                        <td><strong>Total</strong></td>
                        <td><strong>{{ $totalx }}</strong></td>
                        <td><strong>{{ $totaly }}</strong></td>
                        <td><strong>{{ $totalx2 }}</strong></td>
                        <td><strong>{{ $totaly2 }}</strong></td>
                        <td><strong>{{ $totalxy }}</strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5>Menghitung nilai Konstanta (a) dan koefisien (b)</h5>
        <?php $konstanta_a = (($totaly*$totalx2) - ($totaly*$totalxy)) / (($totalno*$totalx2) - ($totalx*$totalx) )  ?>
        <?php $koefisien_b = (($totalno*$totalxy) - ($totalx*$totaly)) / (($totalno*$totalx2) - ($totalx*$totalx) )  ?>
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <tr class="text-center">
                        <td><strong>Konstantan A</strong></td>
                        <td><strong>Konstantan B</strong></td>
                    </tr>
                    <tr class="text-center">
                        <td><strong>{{ abs($konstanta_a) }}</strong></td>
                        <td><strong>{{ $koefisien_b }}</strong></td>
                    </tr>
                </table>
            </div>
            <?php $nilaiY = abs($konstanta_a) + ($koefisien_b*22)  ?>
            <h5>Nilai dari persamaan dengan menggunakan metode regresi linear sederhana adalah sebagai berikut dimana Y = <strong>{{ round($nilaiY) }}</strong> <br />
            Maka estimasi Stok barang pada besok hari tanggal {{ date('d-m-Y', strtotime('+1 day')) }} adalah sekitar {{ round($nilaiY) }} Kilo</h5>
        </div>
    </div>
</div>