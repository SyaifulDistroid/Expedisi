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
use Illuminate\Support\Arr;

class TransactionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:transaction-list|transaction-create|transaction-edit|transaction-delete', ['only' => ['index','show']]);
        $this->middleware('permission:transaction-create', ['only' => ['create','store']]);
        $this->middleware('permission:transaction-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:transaction-delete', ['only' => ['destroy']]);
    }

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

        $datas = DB::table('transactions') //Transaction::orderBy('id','DESC')
        ->select(
            'transactions.id', 
            'transactions.no_resi', 
            'transactions.cabang', 
            'transactions.nama_pengirim', 
            'transactions.alamat_pengirim',
            'transactions.no_handphone_pengirim',
            'transactions.nama_penerima',
            'transactions.alamat_penerima',
            'transactions.no_handphone_penerima', 
            'transactions.cara_pembayaran',
            'transactions.created_at',
            'transactions.updated_at',
            DB::raw('SUM(data_barang_temps.qty) as total_qty'),
            DB::raw('SUM(data_barang_temps.biaya_barang) as total_biaya') )
        ->join('data_barang_temps', 'data_barang_temps.id_transaction', '=', 'transactions.id')
        ->groupBy(
            'id',
            'no_resi',
            'cabang',
            'nama_pengirim',
            'alamat_pengirim',
            'no_handphone_pengirim',
            'nama_penerima',
            'alamat_penerima',
            'no_handphone_penerima',
            'cara_pembayaran',
            'created_at',
            'updated_at')
            ->whereRaw(' (nama_pengirim like "%'.$cari.'%" or
                no_resi like "%'.$cari.'%" or
                alamat_pengirim like "%'.$cari.'%" or
                no_handphone_pengirim like "%'.$cari.'%" or
                nama_penerima like "%'.$cari.'%" or alamat_penerima like "%'.$cari.'%" or no_handphone_penerima like "%'.$cari.'%" or cabang like "%'.$cari.'%"  )
                '.$q_cara_pembayaran.$q_cabang.$q_tanggal)
                ->paginate(10)
        ;

        return view('transaction.index',compact('datas'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $databarang = DB::table('data_barang_temps')->get();
        return view('transaction.create',compact('databarang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function databarang(Request $request)
    {
        $this->validate($request, [
            'jenis_barang' => 'required',
            'isi_barang' => 'required',
            'qty' => 'required',
            'berat_barang' => 'required',
            'biaya_barang' => 'required'
        ]);

        DataBarangTemp::create($request->all());
        return redirect()->route('transaction.create')
        ->with('success','Data berhasil disimpan.');
    }

    public function clearPrint(Request $request)
    {
        $user = $request->user();
        PrintTemp::where("id_user", $user->id)->delete();

        return redirect()->route('transaction.index')
                ->with('success','Clear ALl Print successfully.');
    }

    public function storePrint(Request $request)
    {
        // $this->validate($request, [
        //     'id_transaction' => 'required',
        // ]);

        $user = $request->user();

        $id_transaction = $request->get('id_transaction');

        for ($i = 0; $i < count($id_transaction); $i++){
            $print = new PrintTemp();
            $print->id_transaction = $id_transaction[$i];
            $print->id_user = $user->id;

            $print->save();
        }

        return redirect()->route('transaction.index')
                ->with('success','Print Add successfully.');
    }


    public function store(Request $request)
    {

        $jenis_barang = $request->get('jenis_barang');
        $isi_barang = $request->get('isi_barang');
        $qty = $request->get('qty');
        $berat_barang = $request->get('berat_barang');
        $biaya_barang = $request->get('biaya_barang');

        $pattern = "/[^0-9]/";
        $replacement = "";

        $allBarang = array();

        $request['cabang'] = $request->user()->cabang;

        $this->validate($request, [
            'no_resi' => 'required',
            'cabang' => 'required',
            'cara_pembayaran'=> 'required',
            'nama_pengirim'=> 'required',
            'alamat_pengirim'=> 'required',
            'no_handphone_pengirim'=> 'required',
            'nama_penerima'=> 'required',
            'alamat_penerima'=> 'required',
            'no_handphone_penerima' => 'required',
            'nama_pengambil_barang' => 'required'
        ]);

        DB::beginTransaction();

        try {

            \Log::info('This is some useful information.');

            $id = Transaction::create($request->all())->id;

            for ($i = 0; $i < count($jenis_barang); $i++){

                $barang = new DataBarangTemp();
                $barang->id_transaction = $id;
                $barang->jenis_barang = $jenis_barang[$i];
                $barang->isi_barang = $isi_barang[$i];
                $barang->qty = preg_replace($pattern, $replacement, $qty[$i]);
                $barang->berat_barang = preg_replace($pattern, $replacement, $berat_barang[$i]);
                $barang->biaya_barang = preg_replace($pattern, $replacement, $biaya_barang[$i]);

                \Log::info('$barang->id_transaction : '.$barang->id_transaction);
                \Log::info('$barang->jenis_barang : '.$barang->jenis_barang);
                \Log::info('$barang->isi_barang : '.$barang->isi_barang);
                \Log::info('$barang->qty : '.$barang->qty);
                \Log::info('$barang->berat_barang : '.$barang->berat_barang);
                \Log::info('$barang->biaya_barang : '.$barang->biaya_barang);

                \Log::info('===============================');

                $barang->save();
                array_push($allBarang, $barang);
            }

            DB::commit();

            return redirect()->route('transaction.index')
                ->with('success','Transaction created successfully.');

            // all good
        } catch (\Exception $e) {
//            DB::rollback();
            // something went wrong

            \Log::info($e->getMessage());

            return back()->withError("Gagal insert data, periksa input data.")->withInput();
        }


        return redirect()->route('transaction.index')
                        ->with('success','Transaction created failed.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Transaction::find($id);
        $detail = DataBarangTemp::where('id_transaction', $data->id)->get();

//        dd($data);
//        dd($detail);

        return view('transaction.show', compact('data', 'detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Transaction::find($id);
        $detail = DataBarangTemp::where('id_transaction', $data->id)->get();

        return view('transaction.edit', compact('data', 'detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $jenis_barang = $request->get('jenis_barang');
        $isi_barang = $request->get('isi_barang');
        $qty = $request->get('qty');
        $berat_barang = $request->get('berat_barang');
        $biaya_barang = $request->get('biaya_barang');

        $request['cabang'] = $request->user()->cabang;


        $pattern = "/[^0-9]/";
        $replacement = "";

//        var_dump(preg_replace($pattern, $replacement, $biaya_barang[0])); exit;

        $this->validate($request, [
            'no_resi' => 'required',
            'cabang' => 'required',
            'cara_pembayaran'=> 'required',
            'nama_pengirim'=> 'required',
            'alamat_pengirim'=> 'required',
            'no_handphone_pengirim'=> 'required',
            'nama_penerima'=> 'required',
            'alamat_penerima'=> 'required',
            'no_handphone_penerima' => 'required'
        ]);

        DB::beginTransaction();

        try {

            $transaction = Transaction::find($id);
            $transaction->update($request->all());

            DataBarangTemp::where("id_transaction", $id)->delete();

            for ($i = 0; $i < count($jenis_barang); $i++){

                $barang = new DataBarangTemp();
                $barang->id_transaction = $id;
                $barang->jenis_barang = $jenis_barang[$i];
                $barang->isi_barang = $isi_barang[$i];
                $barang->qty = preg_replace($pattern, $replacement, $qty[$i]);
                $barang->berat_barang = preg_replace($pattern, $replacement, $berat_barang[$i]);
                $barang->biaya_barang = preg_replace($pattern, $replacement, $biaya_barang[$i]);

                $barang->save();
            }

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
//            $request->session()->get('errors', $e);

            return back()->withError("Gagal update data, periksa input data.")->withInput();
        }

        return redirect()->route('transaction.index')
            ->with('success','Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DataBarangTemp::where("id_transaction", $id)->delete();
        Transaction::find($id)->delete();

        return redirect()->route('transaction.index')
                        ->with('success','Transaction deleted successfully');
    }

    public function destroydatabarang($id, $idtransaction)
    {
        DataBarangTemp::find($id)->delete();
        return redirect()->route('transaction.edit', $idtransaction)
            ->with('success','Data berhasil dihapus.');
    }
}
