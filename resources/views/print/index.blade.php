@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Transaction</h2>
        </div>
        <div class="pull-right">
            @can('transaction-create')
                <a class="btn btn-success" href="{{ route('transaction.create') }}"> Create New Transaction</a>
            @endcan
        </div>
    </div>
</div>

<br>
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

{!! Form::open(array('route' => 'transaction.index','method'=>'GET')) !!}

<div class="row">

    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <strong>Pembayaran dengan:</strong>
            {!! Form::select('cara_pembayaran', array('' => 'Pilih cara pembayaran', 'LUNAS' => 'LUNAS', 'TAGIH' => 'TAGIH', 'FRANCO' => 'FRANCO'), app('request')->input('cara_pembayaran'), array('class' => 'form-control')) !!}
        </div>
    </div>

    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <strong>Tanggal awal:</strong>

            <div class="input-group date">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
                <input placeholder="Pilih tanggal" type="date" value="{{ app('request')->input('tanggal_awal')  }}" class="form-control datepicker" name="tanggal_awal">
            </div>

        </div>
    </div>

    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <strong>Tanggal akhir:</strong>

            <div class="input-group date">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
                <input placeholder="Pilih tanggal" type="date" value="{{ app('request')->input('tanggal_akhir')  }}" class="form-control datepicker" name="tanggal_akhir">
            </div>

        </div>
    </div>

    <div class="col-xs-1 col-sm-1 col-md-1" style="">
        <div class="form-group" style="margin-top: 23px">
            <input name="check_tanggal" class="form-check-input" type="checkbox" value="checked" id="flexCheckDefault" {{ app('request')->input('check_tanggal')  }}>
            <label class="form-check-label" for="flexCheckDefault">
                Gunakan tanggal
            </label>
        </div>
    </div>

    <div class="col-xs-1 col-sm-1 col-md-1" style="">
        <div class="form-group">
            <button type="submit" class="btn btn-success form-control" style="margin-top: 23px">Filter</button>
        </div>
    </div>


    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <strong>Cari:</strong>
            {!! Form::text('search', app('request')->input('search'), array('placeholder' => 'cari...','class' => 'form-control')) !!}
        </div>
    </div>

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
     <th></th>
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
    <td>
       <a class="btn btn-info" href="{{ route('transaction.show',$data->id) }}">Show</a>

        @can('transaction-edit')
       <a class="btn btn-primary" href="{{ route('transaction.edit',$data->id) }}">Edit</a>
        @endcan

        @can('transaction-delete')
        {!! Form::open(['method' => 'DELETE','route' => ['transaction.destroy', $data->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
        @endcan
    </td>
  </tr>
@empty
     <tr>
         <td colspan="12">
             <p style="text-align: center">Data No found!</p>
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
