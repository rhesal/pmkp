<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Penilaian;
use App\Models\Master_unit;
use App\Models\Master_indikator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$penilaian = Penilaian::with('indikator')->get();
        // $penilaian = Master_indikator::with('nilai_mutu','nilai_mutu.tanggal')->get();
        $unit = Master_unit::select('id','unit')->orderBy('unit','ASC')->get();
        return view('pages.hasil-penilaian-mutu',['unitList' => $unit],['type_menu' => '']);
    }

    public function rekapitulasi(Request $request)
    {
        $id = $request->input('data1');
        // $periode = explode("-",$request->input('data2'));
        // $thn = $periode[0];
        // $bln = $periode[1];
        //dd($id);
        //dd($id." | ".$bln."-".$thn);

        //$unit = Master_indikator::with(['unit'])->findOrFail($id);
        $records = Master_indikator::where('unit_id',$id)->get();
        //dd($unit);

        foreach($records as $record){
            //$id = $record->id;
            $indikator = $record->indikator;
            $jenis = $record->jenis_indikator;
            $standar = $record->nilai_standar;

            $data_arr[] = array(
                "indikator" => $indikator,
                "jenis_indikator" => $jenis,
                "nilai_standar" => $standar
            );
        }

        $response = array(
            // "draw" => intval($draw),
            // "iTotalRecords" => $totalRecords,
            // "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $penilaian = Penilaian::create($request->all());
        return response()->json($penilaian);
    }

    public function myMethod(Request $request)
    {
        dd($request);
        $name = $request->input('name');
        $email = $request->input('email');

        // Lakukan sesuatu dengan data

        Alert::success('Berhasil','Data berhasil dihapus');
        //return response()->json(['success' => true]);
        //return redirect('penilaian');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id = $request->input('data1');
        $periode = explode("-",$request->input('data2'));
        $thn = $periode[0];
        $bln = $periode[1];

        //datatables
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Penilaian::select('count(*) as allcount')
                                    ->where('indikator_id', $id)->whereYear('tanggal', $thn)->whereMonth('tanggal', $bln)
                                    ->count();
        $totalRecordswithFilter = Penilaian::select('count(*) as allcount')
                                            ->where('indikator_id', $id)->whereYear('tanggal', $thn)->whereMonth('tanggal', $bln)
                                            ->where('tanggal', 'like', '%' .$searchValue . '%')
                                            ->count();

        // Fetch records
        $records = Penilaian::orderBy($columnName,$columnSortOrder)
                ->where('nilai_mutu.tanggal', 'like', '%' .$searchValue . '%')
                ->where('indikator_id', $id)->whereYear('tanggal', $thn)->whereMonth('tanggal', $bln)
                ->skip($start)
                ->take($rowperpage)
                ->get();

        $compare = Master_indikator::where('id',$id)->get();

        $data_arr = array();

        $keterangan = "";
        $standar = "";

        foreach($records as $record){
            $standar = $record->nilai_standar;
        }

        foreach($records as $record){
            $id = $record->id;
            $tanggal = $record->tanggal;
            $numerator = $record->numerator;
            $denumerator = $record->denumerator;
            $hasil = $record->hasil;

            $myStandar = (int) preg_replace('/[^0-9]/', '', $standar);
            $myHasil = (int) preg_replace('/[^0-9]/', '', $hasil);

            if ($myHasil < $myStandar) {
                $keterangan = "TIDAK TERCAPAI";
            } else {
                $keterangan = "TERCAPAI";
            }

            $data_arr[] = array(
                "tanggal" => $tanggal,
                "numerator" => $numerator,
                "denumerator" => $denumerator,
                "hasil" => $hasil,
                "keterangan" => $keterangan,
                "id" => $id,
            );
        }


        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);

        // $penilaian = Penilaian::where('indikator_id', $id)->whereYear('tanggal', $thn)->whereMonth('tanggal', $bln)->get();
        // return response()->json($penilaian);
    }

    public function chart(Request $request)
    {
        $id = $request->input('data1');
        $periode = explode("-",$request->input('data2'));
        $thn = $periode[0];
        $bln = $periode[1];

        $hasil = Penilaian::select('tanggal')->selectRaw("REPLACE(hasil, '%', '') as hasil")
                    ->where('indikator_id', $id)->whereYear('tanggal', $thn)->whereMonth('tanggal', $bln)
                    ->orderBy('tanggal','ASC')
                    ->pluck('hasil', 'tanggal');

        $labels = $hasil->keys();
        $datas = $hasil->values();

        $response = array(
            "labels" => $labels,
            "datas" => $datas
        );

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $penilaian = Penilaian::findOrFail($id);
        $penilaian->update($data);
        return response()->json($penilaian);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $penilaian->delete();
        return response()->json(['message' => 'Data deleted successfully']);
    }
}
