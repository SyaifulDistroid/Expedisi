<!DOCTYPE html>
<html>
<head>
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>

	<h5>USAHA JASA ANGKUTAN DARAT</h5>
	<h5>HANI EXPRES</h5>
	<h6>JL. KERTIJAYAN PEKALONGAN</h6>
	<h6>PEKALONGAN</h6>

	<br><br>

	<table>
		<tr>
			<td>Jurusan: {{ $jurusan }}</td>
			<td>&nbsp;&nbsp;&nbsp;</td>
			<td>Tanggal: {{ $now }}</td>
		</tr>
		<tr>
			<td>No Polisi: {{ $no_polisi }}</td>
			<td>&nbsp;&nbsp;&nbsp;</td>
			<td>Supir: {{ $supir }}</td>
		</tr>
	</table>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>No. Resi</th>
				<th>Pembayaran</th>
				<th>Pengirim</th>
				<th>Kota</th>
				<th>Penerima</th>
				<th>Alamat Penerima</th>
				<th>Jenis Barang</th>
				<th>Jumlah</th>
				<th>Berat</th>
				<th>Ongkos</th>
			</tr>
		</thead>
		<tbody>
			@php 
			
				$i=1;
				$tot_jumlah = 0;
				$tot_berat = 0;
				$tot_biaya = 0;
			
			@endphp

			@foreach($print as $p)

			@php
				$tot_jumlah += $p->qty;
				$tot_berat += $p->berat_barang;
				$tot_biaya += $p->biaya_barang;
			@endphp

			<tr>
				<td>{{ $i++ }}</td>
				<td>{{$p->no_resi}}</td>
				<td>{{$p->cara_pembayaran}}</td>
				<td>{{$p->nama_pengirim}}</td>
				<td>{{$p->alamat_pengirim}}</td>
				<td>{{$p->nama_penerima}}</td>
				<td>{{$p->alamat_penerima}}</td>
				<td>{{$p->jenis_barang}}</td>
				<td>{{$p->qty}}</td>
				<td>{{ number_format( $p->berat_barang )}}</td>
				<td>Rp {{ number_format( $p->biaya_barang)}}</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="8">Total</td>
				<td>{{ number_format( $tot_jumlah )}}</td>
				<td>{{ number_format( $tot_berat )}}</td>
				<td>Rp {{ number_format( $tot_biaya )}}</td>
			</tr>
		</tbody>
	</table>


</body>
</html>