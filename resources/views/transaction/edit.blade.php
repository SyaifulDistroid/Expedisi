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



    {!! Form::open(array( 'route' => ['transaction.update', $data->id],'method'=>'PUT')) !!}

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
                {!! Form::text('nama_pengirim', $data->nama_pengirim, array('placeholder' => 'Nama Pengirim','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>Alamat Pengirim:</strong>
                {!! Form::text('alamat_pengirim', $data->alamat_pengirim, array('placeholder' => 'Alamat Pengirim','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>No Handphone Pengirim:</strong>
                {!! Form::text('no_handphone_pengirim', $data->no_handphone_pengirim, array('placeholder' => 'No Handphone Pengirim','class' => 'form-control')) !!}
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
                {!! Form::text('nama_penerima', $data->nama_penerima, array('placeholder' => 'Nama Penerima','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>Alamat Penerima:</strong>
                {!! Form::text('alamat_penerima', $data->alamat_penerima, array('placeholder' => 'Alamat Penerima','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>No Handphone Penerima:</strong>
                {!! Form::text('no_handphone_penerima', $data->no_handphone_penerima, array('placeholder' => 'No Handphone Penerima','class' => 'form-control')) !!}
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
                {!! Form::select('cara_pembayaran', array('' => 'Pilih cara pembayaran', 'LUNAS' => 'LUNAS', 'TAGIH' => 'TAGIH', 'FRANCO' => 'FRANCO'), $data->cara_pembayaran, array('class' => 'form-control')) !!}
            </div>
        </div>

        <input type="hidden" id="count">

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

            @php($idtransaction = $data->id)
            @foreach($detail as $data)
                <tr>
                    <td>{!! Form::text('jenis_barang[]', $data->jenis_barang, array('placeholder' => 'jenis_barang','class' => 'form-control')) !!}</td>
                    <td>{!! Form::text('isi_barang[]', $data->isi_barang, array('placeholder' => 'isi_barang','class' => 'form-control')) !!}</td>
                    <td>{!! Form::text('qty[]', $data->qty, array('placeholder' => 'qty','class' => 'form-control')) !!}</td>
                    <td>{!! Form::text('berat_barang[]', $data->berat_barang, array('placeholder' => 'berat_barang','class' => 'form-control')) !!}</td>
                    <td>{!! Form::text('biaya_barang[]', $data->biaya_barang, array('placeholder' => 'biaya_barang','class' => 'form-control')) !!}</td>
                </tr>
            @endforeach

        </table>

        <div class="col-lg-12 margin-tb col-sm-12">
            <button type="submit" class="btn btn-success btn-lg btn-block">Simpan semua data</button>
        </div>

    </div>
    {!! Form::close() !!}

    <script>

        var no = 0;

        // A $( document ).ready() block.
        $( document ).ready(function() {
            console.log( "ready!" );

            $("#btnAddData").bind("click",function(){
                // your statements;

                no++;
                console.log( "clicked!" );

                $('#dataTable tr:last').after("" +
                    "<tr>" +
                    "<td><input class='form-control' placeholder='jenis barang' id='jenis_barang"+no+"' name='jenis_barang[]' value='"+$("#jenis_barang").val()+"' ></td>" +
                    "<td><input class='form-control' placeholder='isi barang' id='isi_barang"+no+"' name='isi_barang[]' value='"+$("#isi_barang").val()+"' ></td>" +
                    "<td><input class='form-control' placeholder='qty' id='qty'"+no+"' name='qty[]' value='"+$("#qty").val()+"' ></td>" +
                    "<td><input class='form-control' placeholder='berat barang' id='berat_barang"+no+"' name='berat_barang[]' value='"+$("#berat_barang").val()+"' ></td>" +
                    "<td><input class='form-control' placeholder='biaya barang' id='biaya_barang"+no+"' name='biaya_barang[]' value='"+$("#biaya_barang").val()+"' ></td>" +
                    "<td><button type='button' class='btn btn-danger drop' onclick='drop($(this))'>Hapus</button></td>" +
                    "</tr>");

                $("#count").val(no)
            });

            $("tr td .drop").bind("click", function(){
                $(this).parent("tr:first").remove()
            });

        });

        function drop(row)
        {
            no--;
            $("#count").val(no)
            row.closest('tr').remove();
        }

    </script>

@endsection
