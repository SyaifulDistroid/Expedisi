@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Transaksi</h2>
        </div>
        <div class="pull-right">
            @can('transaction-create')
                <a class="btn btn-success" href="{{ route('transaction.create') }}"> Buat Transaksi Baru</a>
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


<div class="row">
    <div class="col-xs-2 col-sm-2 col-md-2">
        <div class="form-group">
            <a href="{{ route('print.index') }}" class="btn btn-success form-control">Cetak</a>
        </div>
    </div>
    {!! Form::open(array('route' => 'transaction.storeprint','method'=>'POST')) !!}
    <div class="col-md-12" id="formPrint">
        <div class="form-group">
            <button type="submit" class="btn btn-success form-control">Tambah ke Cetak</button>
        </div>
    </div>
    {!! Form::close() !!}

    {!! Form::open(array('route' => 'transaction.clearprint','method'=>'POST')) !!}
    <div class="col-md-12">
        <div class="form-group">
            <button type="submit" class="btn btn-danger form-control">Bersihkan semua Cetak</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>


<table class="table table-bordered">
 <tbody>
    <tr>
        <th>No.</th>
        <th>Cabang</th>
        <th>No. Resi</th>
        <th>Nama Pengirim</th>
        {{-- <th>Alamat Pengirim</th>
        <th>No Handphone Pengirim</th> --}}
        <th>Total Qty</th>
        <th>Total Biaya</th>
        <th>Nama Penerima</th>
        <th>Alamat Penerima</th>
        <th>No Handphone Penerima</th>
        <th>Cara Pembayaran</th>
        <th>Dibuat Tgl</th>
        <th>Cetak <input type="checkbox" onclick="OnClickCheckboxAll(this)"> </th>
        <th></th>
     </tr>
     @php $index = 0; @endphp
     @forelse ($datas as $data)
      <tr class="data_table">
        <td>{{ ++$i }}.</td>
        <td style="display: none" id="id_{{ $index }}">{{ $data->id }}</td>
        <td>{{ $data->cabang }}</td>
        <td>{{ $data->no_resi }}</td>
        <td>{{ $data->nama_pengirim }}</td>
        {{-- <td>{{ $data->alamat_pengirim }}</td>
        <td>{{ $data->no_handphone_pengirim }}</td> --}}
        <td>{{ $data->total_qty }}</td>
        <td class="rupiahWithSymbol" >Rp {{ number_format( $data->total_biaya ) }}</td>
        <td>{{ $data->nama_penerima }}</td>
        <td>{{ $data->alamat_penerima }}</td>
        <td>{{ $data->no_handphone_penerima }}</td>
        <td>{{ $data->cara_pembayaran }}</td>
        <td>{{ $data->created_at }}</td>
        <td><input id="checkbox_{{ $index }}" type="checkbox" onclick="OnClickCheckbox('{{ $data->id }}', this)" /></td>
        <td>
           <a class="btn btn-info" href="{{ route('transaction.show',$data->id) }}">Lihat</a>
    
            @can('transaction-edit')
           <a class="btn btn-primary" href="{{ route('transaction.edit',$data->id) }}">Ubah</a>
            @endcan
    
            @can('transaction-delete')
            {!! Form::open(['method' => 'DELETE','route' => ['transaction.destroy', $data->id],'style'=>'display:inline']) !!}
                {!! Form::submit('Hapus', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
            @endcan
        </td>
      </tr>
 </tbody>
 @php $index++; @endphp
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

    $(document).ready(function() {

        // console.log($(".datepicker").val());
        // $(".datepicker").datepicker({
        //     format: 'yyyy-mm-dd',
        //     autoclose: true,
        //     todayHighlight: true,
        // });

        // $(".rupiahWithSymbol").text( formatRupiah( $(this).text(), "Rp. ") );

    });

    function OnClickCheckbox(id, checkbox) {

        console.log("clicked "+id);

        if ($(checkbox).is(":checked"))
        {
            console.log("checked");

            var t = $("<input style='display:none' id='print_"+id+"' type='text' name='id_transaction[]' value='"+id+"'>");
            $("#formPrint").append(t);
        } else {
            $("#print_"+id).remove();
        }

    }

    function OnClickCheckboxAll(checkbox){
        $('.data_table').each(function(index, tr) {

                console.log(index);
                // console.log(tr);
                var id = $("#id_"+index).text();

                console.log("id-> "+id);

            if ($(checkbox).is(":checked")){

                $("#checkbox_"+index).prop('checked', true);

                var t = $("<input style='display:none' id='print_"+id+"' type='text' name='id_transaction[]' value='"+id+"'>");
                $("#formPrint").append(t);
            } else {

                $("#checkbox_"+index).prop('checked', false);

                $("#print_"+id).remove();
            }

        });
    }

</script>

@endsection
