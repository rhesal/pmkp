<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Penilaian;
use App\Models\Master_unit;

use Illuminate\Http\Request;
use App\Models\Master_indikator;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$penilaian = Penilaian::with('indikator')->get();
        $penilaian = Master_indikator::with('nilai_mutu','nilai_mutu.tanggal')->get();
        $unit = Master_unit::select('id','unit')->get();
        return view('pages.hasil-penilaian-mutu',['penilaianList' => $penilaian, 'unitList' => $unit],['type_menu' => '']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $indikator = Penilaian::create($request->all());
        Alert::success('Berhasil','Data berhasil ditambahkan');
        if ($indikator) {
            Session::flash('status','success');
            Session::flash('message','Add new indikator success !!');
        }
        return redirect('indikator');
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
    public function show(Request $request,string $id)
    {
        //dd($id);
        $penilaian = Penilaian::where('indikator_id', $id)->whereMonth('tanggal', Carbon::now()->month)->get();
        // dd($penilaian);
        return response()->json($penilaian);

        // if ($request->ajax()) {
        //     $model = Penilaian::where('indikator_id', $id)->whereMonth('tanggal', Carbon::now()->month)->get();
        //         return DataTables::eloquent($model)->toJson();
        // }
        // return view('indikator');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
