<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DataBarangTemp;
use App\Models\Transaction;
use App\Models\User;
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
        $cara_pembayaran = $request->cara_pembayaran;

        $q_cara_pembayaran = "";
        if ($cara_pembayaran != ""){
            $q_cara_pembayaran = ' AND cara_pembayaran = "'.$cara_pembayaran.'" ';
        }

        $datas = Transaction::orderBy('id','DESC')
            ->whereRaw(' (nama_pengirim like "%'.$cari.'%" or
            alamat_pengirim like "%'.$cari.'%" or
            no_handphone_pengirim like "%'.$cari.'%" or
            nama_penerima like "%'.$cari.'%" or alamat_penerima like "%'.$cari.'%" or no_handphone_penerima like "%'.$cari.'%" )
            '.$q_cara_pembayaran)
            ->paginate(2);

//        DB::enableQueryLog(); // Enable query log
//        dd(DB::getQueryLog()); // Show results of log

//        dd($datas->toSql());

        return view('transaction.index',compact('datas'))
            ->with('i', ($request->input('page', 1) - 1) * 2);
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


    public function store(Request $request)
    {

        $jenis_barang = $request->get('jenis_barang');
        $isi_barang = $request->get('isi_barang');
        $qty = $request->get('qty');
        $berat_barang = $request->get('berat_barang');
        $biaya_barang = $request->get('biaya_barang');

        $allBarang = array();

        $this->validate($request, [
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

            $id = Transaction::create($request->all())->id;

            for ($i = 0; $i < count($jenis_barang); $i++){

                $barang = new DataBarangTemp();
                $barang->id_transaction = $id;
                $barang->jenis_barang = $jenis_barang[$i];
                $barang->isi_barang = $isi_barang[$i];
                $barang->qty = $qty[$i];
                $barang->berat_barang = $berat_barang[$i];
                $barang->biaya_barang = $biaya_barang[$i];

                $barang->save();
                array_push($allBarang, $barang);
            }



            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }


        return redirect()->route('transaction.index')
                        ->with('success','Transaction created successfully.');
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

//        var_dump($jenis_barang); exit;
//
        $this->validate($request, [
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
                $barang->qty = $qty[$i];
                $barang->berat_barang = $berat_barang[$i];
                $barang->biaya_barang = $biaya_barang[$i];

                $barang->save();
            }

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
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
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    public function destroydatabarang($id, $idtransaction)
    {
        DataBarangTemp::find($id)->delete();
        return redirect()->route('transaction.edit', $idtransaction)
            ->with('success','Data berhasil dihapus.');
    }
}
