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

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif



    {!! Form::open(array( 'route' => ['transaction.update', $data->id],'method'=>'PUT')) !!}

    <div class="row">

        <div class="col-lg-12 margin-tb"><p></p></div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>No. Resi:</strong>
                {!! Form::text('no_resi', $data->no_resi, array('placeholder' => 'No. Resi','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>Cabang:</strong>
                {!! Form::text('cabang', app('auth')->user()->cabang, array('placeholder' => 'Cabang','class' => 'form-control', 'disabled' => 'disabled')) !!}
                {{--            'disabled' => 'disabled'--}}
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <p style="font-size: 20px; text-align: center">
                    <strong id="clock">00:00:00</strong>
                    <br>
                    <label id="date_wrapper"></label>
                </p>
            </div>
        </div>

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
                {!! Form::number('no_handphone_pengirim', $data->no_handphone_pengirim, array('placeholder' => 'No Handphone Pengirim','class' => 'form-control', 'type' => 'number')) !!}
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
                {!! Form::number('no_handphone_penerima', $data->no_handphone_penerima, array('placeholder' => 'No Handphone Penerima','class' => 'form-control', 'type' => 'number')) !!}
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
            @foreach($detail as $no => $data)
                <tr>
                    <td>{!! Form::text('jenis_barang[]', $data->jenis_barang, array('placeholder' => 'jenis_barang','class' => 'form-control')) !!}</td>
                    <td>{!! Form::text('isi_barang[]', $data->isi_barang, array('placeholder' => 'isi_barang','class' => 'form-control')) !!}</td>
{{--                    <td><input type="text" name="qty[]" class="form-control rupiah" value="formatRupiah(<?=$data->qty?>)"></td>--}}
                    <td>{!! Form::text('qty[]', $data->qty, array('placeholder' => 'qty','class' => 'form-control rupiah', 'id' => 'qty'.$no)) !!}</td>
                    <td>{!! Form::text('berat_barang[]', $data->berat_barang, array('placeholder' => 'berat_barang','class' => 'form-control rupiah', 'id' => 'berat_barang'.$no)) !!}</td>
                    <td>{!! Form::text('biaya_barang[]', $data->biaya_barang, array('placeholder' => 'biaya_barang','class' => 'form-control rupiahWithSymbol', 'id' => 'biaya_barang'.$no)) !!}</td>
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

            var noRow = 0;
            $('#dataTable tr').each(function() {
                var self = $(this);

                if ($("#qty"+noRow).val() != undefined){
                    // console.log(noRow);
                    // console.log($("#qty"+noRow).val());


                    $("#qty"+noRow).val( formatRupiah( $("#qty"+noRow).val()) );
                    $("#berat_barang"+noRow).val( formatRupiah( $("#berat_barang"+noRow).val()) );
                    $("#biaya_barang"+noRow).val( formatRupiah( $("#biaya_barang"+noRow).val(), "Rp. ") );
                }

                noRow++;


                $(".rupiahWithSymbol").on("input", function() {
                    $(this).val( formatRupiah( $(this).val(), "Rp. ") );
                });

                $(".rupiah").on("input", function() {
                    $(this).val( formatRupiah( $(this).val()) );
                });

            });
            //
            // $(".rupiahWithSymbol").on("input", function() {
            //     $(this).val( formatRupiah( $(this).val(), "Rp. ") );
            // });
            //
            // $(".rupiah").on("input", function() {
            //     $(this).val( formatRupiah( $(this).val()) );
            // });


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

            setInterval(function() {
                updateClock();
            }, 1000)

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

        function updateClock (){
            var currentTime = new Date ( );
            var currentHours = currentTime.getHours ( );
            var currentMinutes = currentTime.getMinutes ( );
            var currentSeconds = currentTime.getSeconds ( );

            var day = currentTime.getDay();
            var dayarr =["Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"]; day = dayarr[day];

            var year = currentTime.getFullYear();
            var month = currentTime.getMonth();
            var tgl = currentTime.getDate();

            var montharr = ["Desember", "Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November" ];
            month = montharr[month];

            // Pad the minutes and seconds with leading zeros, if required
            currentHours = ( currentHours < 10 ? "0" : "" ) + currentHours;
            currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
            currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

            // Choose either "AM" or "PM" as appropriate
            var timeOfDay = ""; // ( currentHours < 12 ) ? "AM" : "PM";

            // Convert the hours component to 12-hour format if needed
            // currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

            // Convert an hours component of "0" to "12"
            // currentHours = ( currentHours == 0 ) ? 12 : currentHours;

            // Compose the string for display
            var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
            var currentDateString = day+", "+ tgl+" "+month+" "+year;

            $("#clock").html(currentTimeString);
            $("#date_wrapper").html(currentDateString);
        }

        function drop(row)
        {
            no--;
            $("#count").val(no)
            row.closest('tr').remove();
        }

    </script>

@endsection
