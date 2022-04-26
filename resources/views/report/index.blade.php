@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Report</h2>
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

{{-- {!! Form::open(array('route' => 'print.addDataPrint','method'=>'POST')) !!}

    <div class="row">
        
        <div class="col-3">
            <div class="form-group">
                {!! Form::text('search', app('request')->input('search'), array('placeholder' => 'Cari','class' => 'form-control')) !!}
            </div>
        </div>

    </div>

{!! Form::close() !!} --}}

<table class="table table-bordered">
 <tr>
    <th>No.</th>
    <th>Cabang</th>
    <th>No. Resi</th>
    <th>Total Jumlah Barang</th>
    <th>Total Berat Barang</th>
    <th>Total Biaya Barang</th>
    <th>Dibuat Tgl</th>
 </tr>
 @forelse ($datas as $data)
  <tr>
    <td>{{ ++$i }}.</td>
    <td>{{ $data->cabang }}</td>
    <td>{{ $data->no_resi }}</td>
    <td>{{ number_format( $data->total_qty ) }}</td>
    <td>{{ number_format( $data->total_berat ) }}</td>
    <td>Rp {{ number_format( $data->total_biaya ) }}</td>
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
