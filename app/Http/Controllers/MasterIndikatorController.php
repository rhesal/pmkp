<?php

namespace App\Http\Controllers;

use App\Models\Master_unit;
use App\Models\Master_indikator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class MasterIndikatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $indikator = Master_indikator::with('unit')->paginate(10);
        $indikatorGet = Master_indikator::with('unit')->get();
        $unit = Master_unit::select('id','unit')->get();
        return view('pages.indikator',['indikatorList' => $indikator, 'unitList' => $unit, 'indikatorGet' => $indikatorGet],['type_menu' => '']);
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
        $indikator = Master_indikator::create($request->all());
        Alert::success('Berhasil','Data berhasil ditambahkan');
        if ($indikator) {
            Session::flash('status','success');
            Session::flash('message','Add new indikator success !!');
        }   
        return redirect('indikator');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $unit = Master_indikator::with(['unit'])->findOrFail($id);
        return response()->json($unit);
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
