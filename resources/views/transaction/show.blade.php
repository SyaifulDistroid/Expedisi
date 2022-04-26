@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-3 margin-tb">
            <div class="pull-left">
                <h2>Buat Transaksi</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('transaction.index') }}"> Kembali</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">


        <div class="col-lg-12 margin-tb"><p></p></div>

        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h4>Data Pengirim</h4>
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>Nama Pengirim:</strong>
                {!! Form::text('nama_pengirim', $data->nama_pengirim, array('placeholder' => 'Nama Pengirim','class' => 'form-control', 'disabled' => 'disabled')) !!}
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>Alamat Pengirim:</strong>
                {!! Form::text('alamat_pengirim', $data->alamat_pengirim, array('placeholder' => 'Alamat Pengirim','class' => 'form-control', 'disabled' => 'disabled' )) !!}
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>No Handphone Pengirim:</strong>
                {!! Form::text('no_handphone_pengirim', $data->no_handphone_pengirim, array('placeholder' => 'No Handphone Pengirim','class' => 'form-control', 'disabled' => 'disabled' )) !!}
            </div>
        </div>

        <div class="col-lg-12 margin-tb"><p></p></div>

        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h4>Data Penerima</h4>
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>Nama Penerima:</strong>
                {!! Form::text('nama_penerima', $data->nama_penerima, array('placeholder' => 'Nama Penerima','class' => 'form-control', 'disabled' => 'disabled' )) !!}
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>Alamat Penerima:</strong>
                {!! Form::text('alamat_penerima', $data->alamat_penerima, array('placeholder' => 'Alamat Penerima','class' => 'form-control', 'disabled' => 'disabled' )) !!}
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>No Handphone Penerima:</strong>
                {!! Form::text('no_handphone_penerima', $data->no_handphone_penerima, array('placeholder' => 'No Handphone Penerima','class' => 'form-control', 'disabled' => 'disabled' )) !!}
            </div>
        </div>

        <div class="col-lg-12 margin-tb"><p></p></div>

        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h4>Pembayaran</h4>
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>Pembayaran dengan:</strong>
                {!! Form::select('cara_pembayaran', array('' => 'Pilih cara pembayaran', 'LUNAS' => 'LUNAS', 'TAGIH' => 'TAGIH', 'FRANCO' => 'FRANCO'), $data->cara_pembayaran, array('class' => 'form-control', 'disabled' => 'disabled' )) !!}
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>Nama Pengambil Barang:</strong>
                {!! Form::text('nama_pengambil_barang', $data->nama_pengambil_barang, array('placeholder' => 'Nama Pengambil Barang','class' => 'form-control', 'type' => 'text', 'disabled' => 'disabled')) !!}
            </div>
        </div>

        <div class="col-lg-12 margin-tb"><p></p></div>

        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h4>Data Barang</h4>
            </div>
        </div>

        <table class="table table-bordered" id="dataTable">
            <tr>
                <th>Jenis Barang</th>
                <th>Isi Barang</th>
                <th>Qty</th>
                <th>Berat Barang</th>
                <th>Biaya Barang</th>
            </tr>

                @foreach($detail as $no => $data)
                    <tr>
                        <td id="jenis_barang{{$no}}">{{ $data->jenis_barang }}</td>
                        <td id="isi_barang{{$no}}">{{ $data->isi_barang }}</td>
                        <td id="qty{{$no}}">{{ $data->qty }}</td>
                        <td id="berat_barang{{$no}}">{{ $data->berat_barang }}</td>
                        <td id="biaya_barang{{$no}}">{{ $data->biaya_barang }}</td>
                    </tr>
                @endforeach

        </table>

    </div>

    <script>
        var noRow = 0;
        $('#dataTable tr').each(function() {
            var self = $(this);

            if ($("#qty"+noRow).val() != undefined){
                // console.log(noRow);
                // console.log($("#qty"+noRow).val());


                $("#qty"+noRow).text( formatRupiah( $("#qty"+noRow).text()) );
                $("#berat_barang"+noRow).text( formatRupiah( $("#berat_barang"+noRow).text()) );
                $("#biaya_barang"+noRow).text( formatRupiah( $("#biaya_barang"+noRow).text(), "Rp. ") );
            }

            $(".rupiahWithSymbol").on("input", function() {
                $(this).val( formatRupiah( $(this).val(), "Rp. ") );
            });

            $(".rupiah").on("input", function() {
                $(this).val( formatRupiah( $(this).val()) );
            });

            noRow++;
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }
    </script>
@endsection
