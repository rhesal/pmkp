<?php

namespace App\Http\Controllers;

use App\Models\Master_unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class MasterUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unit = Master_unit::all();
        return view('pages.unit',['unitList' => $unit],['type_menu' => '']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create-unit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $unit = Master_unit::create($request->all());
        if ($unit) {
            Session::flash('status','success');
            Session::flash('message','Add new unit success !!');
        }
        //return redirect('unit');
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
