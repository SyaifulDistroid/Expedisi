@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Cetak</h2>
        </div>
    </div>
</div>

<br>
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning">
        <p>{{ $message }}</p>
    </div>
@endif


<div class="row">
    <div class="col-3">
        <div class="form-group">
            <h3>Pemilik H. Abduh</h3>
        </div>
    </div>
</div>

{!! Form::open(array('route' => 'print.addDataPrint','method'=>'POST')) !!}

    <div class="row">
        
        <div class="col-3">
            <div class="form-group">
                <strong>No. Resi:</strong>
                {!! Form::text('no_resi', app('request')->input('no_resi'), array('placeholder' => 'Masukan No. Resi','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2">
            <div class="form-group">
                <button type="submit" target="_blank" class="btn btn-success form-control" style="margin-top: 23px">Masukan No. Resi</button>
            </div>
        </div>

    </div>

{!! Form::close() !!}

{!! Form::open(array('route' => 'print.print','method'=>'GET')) !!}


<div class="row">
    
    <div class="col-3">
        <div class="form-group">
            <strong>No. Polisi:</strong>
            {!! Form::text('no_polisi', app('request')->input('no_polisi'), array('placeholder' => 'No. Polisi','class' => 'form-control')) !!}
        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            <strong>Supir:</strong>
            {!! Form::text('supir', app('request')->input('supir'), array('placeholder' => 'Supir','class' => 'form-control')) !!}
        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            <strong>Jurusan:</strong>
            {!! Form::text('jurusan', app('request')->input('jurusan'), array('placeholder' => 'Jurusan','class' => 'form-control')) !!}
        </div>
    </div>
    
    <div class="col-xs-2 col-sm-2 col-md-2">
        <div class="form-group">
            <!-- <a href="{{ route('print.print') }}" target="_blank" class="btn btn-success form-control" style="margin-top: 23px">Print</a> -->
            <button type="submit" target="_blank" class="btn btn-success form-control" style="margin-top: 23px">Cetak</button>
        </div>
    </div>

</div>


<div class="row">

</div>

{!! Form::close() !!}

<table class="table table-bordered">
 <tr>
    <th>No.</th>
    <th>Cabang</th>
    <th>No. Resi</th>
    <th>Nama Pengirim</th>
    <th>Alamat Pengirim</th>
    <th>No Handphone Pengirim</th>
    <th>Nama Penerima</th>
    <th>Alamat Penerima</th>
    <th>No Handphone Penerima</th>
    <th>Cara Pembayaran</th>
     <th>Dibuat Tgl</th>
 </tr>
 @forelse ($datas as $data)
  <tr>
    <td>{{ ++$i }}.</td>
    <td>{{ $data->cabang }}</td>
    <td>{{ $data->no_resi }}</td>
    <td>{{ $data->nama_pengirim }}</td>
    <td>{{ $data->alamat_pengirim }}</td>
    <td>{{ $data->no_handphone_pengirim }}</td>
    <td>{{ $data->nama_penerima }}</td>
    <td>{{ $data->alamat_penerima }}</td>
    <td>{{ $data->no_handphone_penerima }}</td>
    <td>{{ $data->cara_pembayaran }}</td>
    <td>{{ $data->created_at }}</td>
  </tr>
@empty
     <tr>
         <td colspan="12">
             <p style="text-align: center">Data Tidak Ada!</p>
         </td>
     </tr>
@endforelse
</table>

{{ $datas->links('layouts.pagination') }}

{{--{!! $datas->render() !!}--}}
{{--{{ $datas->links() }}--}}

<script>
    $(document).ready(function() {

        // console.log($(".datepicker").val());
        // $(".datepicker").datepicker({
        //     format: 'yyyy-mm-dd',
        //     autoclose: true,
        //     todayHighlight: true,
        // });

    });
</script>

@endsection
