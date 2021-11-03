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
            <strong>Cari:</strong>
            {!! Form::text('search', app('request')->input('search'), array('placeholder' => 'cari...','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <strong>Pembayaran dengan:</strong>
            {!! Form::select('cara_pembayaran', array('' => 'Pilih cara pembayaran', 'LUNAS' => 'LUNAS', 'TAGIH' => 'TAGIH', 'FRANCO' => 'FRANCO'), app('request')->input('cara_pembayaran'), array('class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1" style="">
        <div class="form-group">
            <button type="submit" class="btn btn-success form-control" style="margin-top: 23px">Filter</button>
        </div>
    </div>
</div>

{!! Form::close() !!}

<table class="table table-bordered">
 <tr>
    <th>No.</th>
    <th>Nama Pengirim</th>
    <th>Alamat Pengirim</th>
    <th>No Handphone Pengirim</th>
    <th>Nama Penerima</th>
    <th>Alamat Penerima</th>
    <th>No Handphone Penerima</th>
    <th>Cara Pembayaran</th>
     <th></th>
 </tr>
 @forelse ($datas as $data)
  <tr>
    <td>{{ ++$i }}.</td>
    <td>{{ $data->nama_pengirim }}</td>
    <td>{{ $data->alamat_pengirim }}</td>
    <td>{{ $data->no_handphone_pengirim }}</td>
    <td>{{ $data->nama_penerima }}</td>
    <td>{{ $data->alamat_penerima }}</td>
    <td>{{ $data->no_handphone_penerima }}</td>
    <td>{{ $data->cara_pembayaran }}</td>
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
         <td colspan="8">
             <p style="text-align: center">Data No found!</p>
         </td>
     </tr>
@endforelse
</table>

{{ $datas->links('layouts.pagination') }}

{{--{!! $datas->render() !!}--}}
{{--{{ $datas->links() }}--}}


@endsection
