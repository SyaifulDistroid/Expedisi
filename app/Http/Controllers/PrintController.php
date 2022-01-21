<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DataBarangTemp;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;

class PrintController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cari = $request->search;
        $check_tanggal = $request->check_tanggal;

        $cara_pembayaran = $request->cara_pembayaran;

        $q_tanggal = "";
        if ($check_tanggal != ""){
            $q_tanggal = " AND date(`created_at`) BETWEEN '".$request->tanggal_awal."' and '$request->tanggal_akhir' ";
        }

        $q_cara_pembayaran = "";
        if ($cara_pembayaran != ""){
            $q_cara_pembayaran = ' AND cara_pembayaran = "'.$cara_pembayaran.'" ';
        }

        $q_cabang = "";
        if($request->user()->cabang != "All"){
            $q_cabang = " AND cabang = '".$request->user()->cabang."' ";
        }

        $datas = Transaction::orderBy('id','DESC')
            ->whereRaw(' (nama_pengirim like "%'.$cari.'%" or
                alamat_pengirim like "%'.$cari.'%" or
                no_handphone_pengirim like "%'.$cari.'%" or
                nama_penerima like "%'.$cari.'%" or alamat_penerima like "%'.$cari.'%" or no_handphone_penerima like "%'.$cari.'%" or cabang like "%'.$cari.'%"  )
                '.$q_cara_pembayaran.$q_cabang.$q_tanggal)
                ->paginate(10)
        ;

        return view('print.index',compact('datas'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
