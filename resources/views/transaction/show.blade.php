@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-3 margin-tb">
            <div class="pull-left">
                <h2>Buat Transaksi</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('transaction.index') }}"> Back</a>
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

                @php($no = 0)
                @foreach($detail as $data)
                    <tr>
                        <td>{{ $data->jenis_barang }}</td>
                        <td>{{ $data->isi_barang }}</td>
                        <td>{{ $data->qty }}</td>
                        <td>{{ $data->berat_barang }}</td>
                        <td>{{ $data->biaya_barang }}</td>
                    </tr>
                @endforeach

        </table>

    </div>
@endsection
