<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DataBarangTemp;
use App\Models\Transaction;
use App\Models\User;
use App\Models\PrintTemp;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use PDF;
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

        $user = $request->user();

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

        // $datas = Transaction::orderBy('id','DESC')
        //     ->whereRaw(' (nama_pengirim like "%'.$cari.'%" or
        //         alamat_pengirim like "%'.$cari.'%" or
        //         no_handphone_pengirim like "%'.$cari.'%" or
        //         nama_penerima like "%'.$cari.'%" or alamat_penerima like "%'.$cari.'%" or no_handphone_penerima like "%'.$cari.'%" or cabang like "%'.$cari.'%"  )
        //         '.$q_cara_pembayaran.$q_cabang.$q_tanggal)
        //         ->paginate(10)
        ;

        $datas = DB::table('print_temps')
        ->join('transactions', 'transactions.id', '=', 'print_temps.id_transaction' )
        // ->join('data_barang_temps', 'data_barang_temps.id_transaction', '=', 'transactions.id')
        ->where('print_temps.id_user', $user->id)
            ->paginate(10);

        // dd($datas);

        return view('print.index',compact('datas'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function print(Request $request){

        $now = date('d-m-Y H:i:s');
        $no_polisi = $request->no_polisi;
        $supir = $request->supir;

        $user = $request->user();

        $print = DB::table('print_temps')
        ->join('transactions', 'print_temps.id_transaction', '=', 'transactions.id')
        ->join('data_barang_temps', 'transactions.id', '=', 'data_barang_temps.id_transaction')
        ->where('print_temps.id_user', $user->id)
        ->get();

        return view('print/transaction-pdf', compact('print', 'now', 'no_polisi', 'supir'));

        $customPaper = array(0, 0, 595.276, 419.5276); //20 x 10 cm, cm to point
 
    	$pdf = PDF::loadview('print/transaction-pdf',['print'=>$print])->setPaper('a3', 'landscape');;//->setPaper($customPaper);
    	return $pdf->download('transaction-pdf.pdf');
    }

    
}
