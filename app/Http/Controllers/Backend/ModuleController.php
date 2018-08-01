<?php

namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Model\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Datatables;

class ModuleController extends Controller
{
    public function index()
    {
        //
		return view ('backend.module.index');
    }

    public function create()
    {
        //
		return view ('backend.module.update');
    }

    public function store(Request $request)
    {
        //
		$data = new Module();
		$data->name = $request->name;
		$data->slug = $request->slug;
		$data->active = $request->active;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
			return Redirect::to('/backend/modules')->with('success', "Data saved successfully")->with('mode', 'success');
		}

    }

    public function show($id)
    {
        //
		$data = Module::with(['user_modify'])->where('id', $id)->get();
		if ($data->count() > 0){
			return view ('backend.module.view', ['data' => $data]);
		}
    }

    public function edit($id)
    {
        //
		$data = Module::where('id', $id)->where('active', '!=', 0)->get();
		if ($data->count() > 0){
			return view ('backend.module.update', ['data' => $data]);
		}
    }

    public function update(Request $request, $id)
    {
        //
		$data = Module::find($id);
		$data->name = $request->name;
		$data->slug = $request->slug;
		$data->active = $request->active;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
			return Redirect::to('/backend/modules')->with('success', "Data saved successfully")->with('mode', 'success');
		}
    }

    public function destroy(Request $request, $id)
    {
        //
		$data = Module::find($id);
		$data->active = 0;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
			Session::flash('success', 'Data deleted successfully');
			Session::flash('mode', 'success');
			return new JsonResponse(["status"=>true]);
		}else{
			return new JsonResponse(["status"=>false]);
		}
    }
	
	public function datatable() {	
		$userinfo = Session::get('userinfo');
		$data = Module::where('active', '!=', 0);
	
        return Datatables::of($data)
			->addColumn('action', function ($data) {
				
				$url_edit = url('backend/modules/'.$data->id.'/edit');
				
				$url = url('backend/modules/'.$data->id);
				
                return "<a class='btn-action btn btn-primary btn-view' href='".$url."' title='View'><i class='fa fa-eye'></i></a> <a class='btn-action btn btn-info' href='".$url_edit."' title='Edit'><i class='fa fa-edit'></i></a> <button data-url='".$url."' onclick='deleteData(this)' class='btn-action btn btn-danger' title='Delete'><i class='fa fa-trash-o'></i></button>";
            })			
            ->rawColumns(['action'])
            ->make(true);		
	}
 	
}
