<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Master_unit;
use App\Models\Master_indikator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penilaian = Penilaian::with('indikatorMutu')->get();
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
    public function show(string $id)
    {
        //
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
