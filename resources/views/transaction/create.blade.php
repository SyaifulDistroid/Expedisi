@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create Transaction</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('transaction.index') }}"> Back</a>
        </div>
    </div>
</div>


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
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h4>Data Pengirim</h4>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Nama Pengirim:</strong>
            {!! Form::text('nama_pengirim', null, array('placeholder' => 'Nama Pengirim','class' => 'form-control')) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Alamat Pengirim:</strong>
            {!! Form::text('alamat_pengirim', null, array('placeholder' => 'Alamat Pengirim','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>No Handphone Pengirim:</strong>
            {!! Form::text('no_handphone_pengirim', null, array('placeholder' => 'No Handphone Pengirim','class' => 'form-control')) !!}
        </div>
    </div>

    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h4>Data Penerima</h4>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Nama Penerima:</strong>
            {!! Form::text('nama_penerima', null, array('placeholder' => 'Nama Penerima','class' => 'form-control')) !!}
        </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Alamat Penerima:</strong>
            {!! Form::text('alamat_penerima', null, array('placeholder' => 'Alamat Penerima','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>No Handphone Penerima:</strong>
            {!! Form::text('no_handphone_penerima', null, array('placeholder' => 'No Handphone Penerima','class' => 'form-control')) !!}
        </div>
    </div>

    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h4>Data Barang</h4>
        </div>
    </div>

    @php
    $total = 0;    
    $count = 0;
    @endphp 

        <table class="table table-bordered">
            <tr>
            <th>Jenis Barang</th>
            <th>Isi Barang</th>
            <th>Qty</th>
            <th>Berat Barang</th>
            <th>Biaya Barang</th>
            <th>Action</th>
            </tr>
            
            <tr>
                <td>{!! Form::text('jenis_barang', null, array('placeholder' => 'Jenis Barang','class' => 'form-control','id'=>'jenis_barang')) !!}</td>
                <td>{!! Form::text('isi_barang', null, array('placeholder' => 'Isi Barang','class' => 'form-control','id'=>'isi_barang')) !!}</td>
                <td>{!! Form::text('qty', null, array('placeholder' => 'Qty','class' => 'form-control','id'=>'qty')) !!}</td>
                <td>{!! Form::text('berat_barang', null, array('placeholder' => 'Berat Barang','class' => 'form-control','id'=>'berat_barang')) !!}</td>
                <td>{!! Form::text('biaya_barang', null, array('placeholder' => 'Biaya Barang','class' => 'form-control','id'=>'biaya_barang')) !!}</td>

                <td>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <Script>
                            $click = 0;
                            </Script>                      
                        <button type="submit" onclick="saveState($click++)" class="btn btn-primary">Tambah Data</button>
                    </div>
                </td>
            </tr>
        </table> 
        
        <table class="table table-bordered">
            <tr>
            <th>Jenis Barang</th>
            <th>Isi Barang</th>
            <th>Qty</th>
            <th>Berat Barang</th>
            <th>Biaya Barang</th>
            </tr>
            @php
                
                echo $count
            @endphp
            @for ($i = 0; $i < $count++; $i++)
            <tr>
                <td id="jenisbarang"></td>
                <td id="isibarang"></td>
                <td id="qtyval"></td>
                <td id="beratbarang"></td>
                <td id="biayabarang"></td>
            </tr>
            @endfor
            
            @php               
                        // $total = $total + $dbrg->biaya_barang;
                        @endphp
             
            <tr>
                <td colspan="4">
                        <strong>Total Harga Barang</strong>
                </td>
                <td>
                    @php                
                        echo $total;
                    @endphp
                </td>
            </tr>
        </table> 
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>

<script>
    const transaction = [];
    function saveState(click) { 
        // console.log(click)     
        const trans = [];
            trans[0]= document.getElementById("jenis_barang").value;
            trans[1]= document.getElementById("isi_barang").value;
            trans[2]= document.getElementById("qty").value;
            trans[3]= document.getElementById("berat_barang").value;
            trans[4]= document.getElementById("biaya_barang").value;
        
        transaction[click] = trans
            
            document.getElementById("jenisbarang").innerHTML = transaction[click].trans[0];
            document.getElementById("isibarang").innerHTML =  transaction[click];
            document.getElementById("qtyval").innerHTML = transaction[click];
            document.getElementById("beratbarang").innerHTML = transaction[click];
            document.getElementById("biayabarang").innerHTML =  transaction[click];    }
</script>




@endsection