<?php

namespace App\Http\Controllers;

use App\Models\Master_unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Master_indikator;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class MasterUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unit = Master_unit::paginate(10);
        return view('pages.unit',['unitList' => $unit],['type_menu' => '']);
    }

    public function getUnit(Request $request){
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
        $totalRecords = Master_unit::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Master_unit::select('count(*) as allcount')->where('unit', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = Master_unit::orderBy($columnName,$columnSortOrder)
                ->where('master_unit.unit', 'like', '%' .$searchValue . '%')
                ->select('master_unit.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $unit = $record->unit;
            $status = $record->status;

            $data_arr[] = array(
                "id" => $id,
                "unit" => $unit,
                "status" => $status
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }

    public function home()
    {
        $unit = Master_unit::where('status', 'Active')->count('unit');
        $indikator = Master_indikator::where('status', 'Active')->count('indikator');
        $sensus = Penilaian::count('hasil');

        $array = array(
            "unit"=>$unit,
            "indikator"=>$indikator,
            "sensus"=>$sensus
        );
        return response()->json($array);
    }

    public function listHome(Request $request)
    {
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
        $totalRecords = Master_unit::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Master_unit::select('count(*) as allcount')->where('unit', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = Master_unit::orderBy($columnName,$columnSortOrder)
                ->where('unit', 'like', '%' .$searchValue . '%')
                ->where('status', 'Active')
                ->orderBy('unit','ASC')
                ->skip($start)
                ->take($rowperpage)
                ->get();

	    $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $unit = $record->unit;

            $data_arr[] = array(
                // "id" => $id,
                "unit" => $unit
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
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
        Alert::success('Berhasil','Data berhasil ditambahkan');
        if ($unit) {
            Session::flash('status','success');
            Session::flash('message','Add new unit success !!');
        }
        return redirect('unit');
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
        $deleteUnit = Master_unit::findOrFail($id);
        $deleteUnit->delete();
        Alert::success('Berhasil','Data berhasil dihapus');
        if($deleteUnit){
            Session::flash('status','success');
            Session::flash('message','Delete unit success!');
        }
        return redirect('unit');
    }
}
