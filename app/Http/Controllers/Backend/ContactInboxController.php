<?php

namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Model\ContactUs;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Datatables;

class ContactInboxController extends Controller
{
    public function index()
    {
        //
		return view ('backend.contactus.index');
    }

    public function show($id)
    {
        //
		$data = ContactUs::where('id', $id)->get();
		if ($data->count() > 0){
            $data = ContactUs::find($id);
            $data->read = 2;
            $data->save();
            $data = ContactUs::where('id', $id)->get();
			return view ('backend.contactus.view', ['data' => $data]);
		}
    }

    public function destroy(Request $request, $id)
    {
        //
        $data = ContactUs::find($id);
    	$data->active = 0;
        if($data->save()){
            Session::flash('success', 'Data deleted successfully');
            Session::flash('mode', 'success');
            return new JsonResponse(["status"=>true]);
        }else{
            return new JsonResponse(["status"=>false]);
        }
 		return new JsonResponse(["status"=>false]);		
    }

    public function deleteAll(Request $request)
    {
		if (!(empty($_POST['checkall'])))
		{
			foreach($_POST['checkall'] as $item)
			{ 
                $data = ContactUs::find($item);
                $data->active = 0;
                $data->save();
            } 
            return Redirect::to('/backend/contact-inbox/')->with('success', "Data(s) deleted successfully")->with('mode', 'success');
		} else {
            return Redirect::to('/backend/contact-inbox/');
        }
        
    }
    
	public function datatable() {	
		$userinfo = Session::get('userinfo');
		$data = ContactUs::where('active', '!=', 0);
        return Datatables::of($data)
			->addColumn('action', function ($data) {
				$userinfo = Session::get('userinfo');
				$access_control = Session::get('access_control');
				$segment =  \Request::segment(2);
				$url = url('backend/contact-inbox/'.$data->id);
				$view = "<a class='btn-action btn btn-primary btn-view' href='".$url."' title='View'><i class='fa fa-eye'></i></a>";
				$delete = "<button data-url='".$url."' onclick='return deleteData(this)' class='btn-action btn btn-danger btn-delete' title='Delete'><i class='fa fa-trash-o'></i></button>";
				if (!empty($access_control)) {
					if ($access_control[$userinfo['user_level_id']][$segment] == "v"){
						return $view;
					} else if ($access_control[$userinfo['user_level_id']][$segment] == "vu"){
						return $view;
					} else if ($access_control[$userinfo['user_level_id']][$segment] == "a"){
						return $view." ".$delete;
					}
				} else {
					return "";
				}
            })	
            ->editColumn('created_at', function ($data) {
                return date('d-m-Y H:i:s', strtotime($data->created_at));
            })
            ->addColumn('check', function ($data) {
                return "
                    <span class='uni'>
                        <input type='checkbox' value='".$data->id."' name='checkall[]' />
                    </span>
                ";
            })
            ->rawColumns(['action', 'check'])
            ->make(true);		
	}
 	
}
