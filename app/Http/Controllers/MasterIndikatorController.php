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
        $unit = Master_unit::select('id','unit')->orderBy('unit','ASC')->get();
        return view('pages.indikator',['indikatorList' => $indikator, 'unitList' => $unit, 'indikatorGet' => $indikatorGet],['type_menu' => '']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->input('indikator');
        dd($request->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $indikator = Master_indikator::create($request->all());
        Alert::success('Berhasil','Data berhasil ditambahkan');
        if ($indikator) {
            Session::flash('status','success');
            Session::flash('message','Add new indikator success !!');
        }
        // return redirect('indikator');
        return response()->json($indikator);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $unit = Master_indikator::with(['unit'])->findOrFail($id);
        return response()->json($unit);
    }

    public function indikatorByUnit($id)
    {
        $indikator = Master_indikator::where('unit_id', $id)->get();
        //dd($indikator);
        return response()->json($indikator);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id = $request->input('id');
        // $id = "25";
        $units = Master_unit::select('id','unit')->orderBy('unit','ASC')->get();
        $indikators = Master_indikator::where('id', $id)->get();

        $response = array(
            "id" =>$id,
            "units" => $units,
            "indikators" => $indikators,
        );

        // dd($response);
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $indikator = Master_indikator::findOrFail($id);
        $indikator->update($data);
        Alert::success('Berhasil','Data berhasil diupdate');
        if($indikator){
            Session::flash('status','success');
            Session::flash('message','Update unit success!');
        }
        return response()->json($indikator);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deleteIndikator = Master_indikator::findOrFail($id);
        $deleteIndikator->delete();
        // Alert::success('Berhasil','Data berhasil dihapus');
        // Alert::error('Ooppss!','Data gagal dihapus');
        // if($deleteIndikator){
        //     Session::flash('status','success');
        //     Session::flash('message','Delete unit success!');
        // }else{
        //     Session::flash('status','error');
        //     Session::flash('message','Delete unit failed!');
        // }
        // return response()->json($deleteIndikator);
        return response()->json(['message' => 'Data deleted successfully']);
    }
}
