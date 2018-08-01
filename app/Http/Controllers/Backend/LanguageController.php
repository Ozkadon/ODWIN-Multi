<?php

namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Model\Language;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Datatables;
use Validator;

class LanguageController extends Controller
{
    public function index()
    {
        //
		return view ('backend.language.index');
    }

    public function create()
    {
        //
		return view ('backend.language.update');
    }

    public function store(Request $request)
    {
        //
    	$validator = Validator::make($request->all(), [
            'code' => 'required|unique:language,code',
            'name' => 'required',
        ]);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }        
        $data = new Language();
        $data->code = strtoupper($request->code);
        $data->name = ucfirst(strtolower($request->name));
        $data->default = 0;
		$data->active = $request->active;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
			return Redirect::to('/backend/language')->with('success', "Data saved successfully")->with('mode', 'success');
		}

    }

    public function show($id)
    {
        //
		$data = Language::with(['user_modify'])->where('id', $id)->get();
		if ($data->count() > 0){
			return view ('backend.language.view', ['data' => $data]);
		}
    }

    public function edit($id)
    {
        //
		$data = Language::where('id', $id)->get();
		if ($data->count() > 0){
			return view ('backend.language.update', ['data' => $data]);
		}
    }

    public function update(Request $request, $id)
    {
        //
    	$validator = Validator::make($request->all(), [
            'code' => 'required|unique:language,code,'.$id,
            'name' => 'required',
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }        
        $data = Language::find($id);
		$data->code = strtoupper($request->code);
		$data->name = ucfirst(strtolower($request->name));
		$data->active = $request->active;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
			return Redirect::to('/backend/language')->with('success', "Data saved successfully")->with('mode', 'success');
		}
    }

    public function destroy(Request $request, $id)
    {
        //
		$data = Language::find($id);
		if($data->delete()){
			Session::flash('success', 'Data deleted successfully');
			Session::flash('mode', 'success');
			return new JsonResponse(["status"=>true]);
		}else{
			return new JsonResponse(["status"=>false]);
		}
    }
	
	public function datatable() {	
		$userinfo = Session::get('userinfo');
		$data = Language::all();
	
        return Datatables::of($data)
			->addColumn('action', function ($data) {
				
				$url_edit = url('backend/language/'.$data->id.'/edit');
				
                $url = url('backend/language/'.$data->id);
                
                $edit = "<a class='btn-action btn btn-info' href='".$url_edit."' title='Edit'><i class='fa fa-edit'></i></a>";

                $delete = "<button data-url='".$url."' onclick='deleteData(this)' class='btn-action btn btn-danger' title='Delete'><i class='fa fa-trash-o'></i></button>";

                if ($data->id <= 2){
                    $edit = "";
                    $delete = "";
                }

                return "<a class='btn-action btn btn-primary btn-view' href='".$url."' title='View'><i class='fa fa-eye'></i></a> $edit $delete";
            })			
            ->rawColumns(['action'])
            ->make(true);		
	}
 	
}
