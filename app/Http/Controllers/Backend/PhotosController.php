<?php

namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Model\Photos;
use App\Model\PhotosDetail;
use App\Model\PhotosLanguage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Datatables;

class PhotosController extends Controller
{
    public function index()
    {
        //
		return view ('backend.photos.index');
    }

    public function create()
    {
        //
        $detail = [];
        return view ('backend.photos.update', ['detail' => $detail]);
    }

    public function store(Request $request)
    {
		$data = new Photos();
		$data->active = $request->active;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
            $id = $data->id;
            if (isset($_POST['gallery_detail_id'])){
                $i = 0;
                $image_id = 0;
                foreach ($_POST['gallery_detail_id'] as $key => $value){
                    if ($i == 0){
                        $image_id = $value;
                    }
                    $data = new PhotosDetail();
                    $data->photos_id = $id;
                    $data->image_id = $value;
                    $data->save();
                    $i++;
                }
                $data = Photos::find($id);
                $data->image_id = $image_id;
                $data->count = $i;
                $data->save();
            }

            $active_language = Session::get('active_language');
            foreach ($active_language as $language):
                $data = new PhotosLanguage();
                $data->photos_id = $id;
                $data->judul = $_POST['judul_'.$language->code];
                $data->language_code = $language->code;
                $data->save();
            endforeach;

			return Redirect::to('/backend/photos/')->with('success', "Data saved successfully")->with('mode', 'success');
		}
    }

    public function edit($id)
    {
		$data = Photos::where('id', $id)->where('active', '!=', 0)->get();
		if ($data->count() > 0){
            $detail = PhotosDetail::with('media_image_1')->where('photos_id', '=', $id)->orderBy('id', 'ASC')->get();
            $data_language = PhotosLanguage::where('photos_id', $id)->get();
			return view ('backend.photos.update', ['data' => $data, 'detail' => $detail,'data_language' => $data_language]);
		}
        
    }

    public function update(Request $request, $id)
    {
		$data = Photos::find($id);
		$data->active = $request->active;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
            $deletedRows = PhotosDetail::where('photos_id', $id)->delete();
            if (isset($_POST['gallery_detail_id'])){
                $i = 0;
                $image_id = 0;
                foreach ($_POST['gallery_detail_id'] as $key => $value){
                    if ($i == 0){
                        $image_id = $value;
                    }
                    $data = new PhotosDetail();
                    $data->photos_id = $id;
                    $data->image_id = $value;
                    $data->save();
                    $i++;
                }
                $data = Photos::find($id);
                $data->image_id = $image_id;
                $data->count = $i;
                $data->save();
            } else {
                $data = Photos::find($id);
                $data->image_id = 0;
                $data->count = 0;
                $data->save();
            }
            $active_language = Session::get('active_language');
            foreach ($active_language as $language):
                $language_exist = PhotosLanguage::where('photos_id', $id)->where('language_code', $language->code)->count();
                if ($language_exist < 1){
                    //INSERT BARU
                    $data = new PhotosLanguage();
                    $data->photos_id = $id;
                    $data->judul = $_POST['judul_'.$language->code];
                    $data->language_code = $language->code;
                    $data->save();
                } else {
                    //UPDATE
                    $check_language_id = PhotosLanguage::where('photos_id', $id)->where('language_code', $language->code)->first();
                    $data = PhotosLanguage::find($check_language_id->id);
                    $data->judul = $_POST['judul_'.$language->code];
                    $data->save();
                }
            endforeach;
			return Redirect::to('/backend/photos/')->with('success', "Data saved successfully")->with('mode', 'success');
		}
        
    }

    public function destroy(Request $request, $id)
    {
        //
        $data = Photos::find($id);
        $data->user_modified = Session::get('userinfo')['user_id'];
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
	
	public function datatable() {	
        $default_language = Session::get('default_language');
        $data = Photos::select('photos.*','photos_language.judul')
                ->leftJoin('photos_language','photos.id','=','photos_language.photos_id')
                ->where('photos_language.language_code','=', $default_language->code)
                ->where('photos.active', '!=', 0);
        return Datatables::of($data)
			->addColumn('action', function ($data) {
				$userinfo = Session::get('userinfo');
				$access_control = Session::get('access_control');
				$segment =  \Request::segment(2);
				$url_edit = url('backend/photos/'.$data->id.'/edit');
                $url = url('backend/photos/'.$data->id);
                $url_view = url('photos/'.$data->slug);
				$view = "<a class='btn-action btn btn-primary' target='_blank' href='".$url_view."' title='View'><i class='fa fa-eye'></i></a>";
				$edit = "<a class='btn-action btn btn-info btn-edit' href='".$url_edit."' title='Edit'><i class='fa fa-edit'></i></a>";
                $delete = "<button data-url='".$url."' onclick='deleteData(this)' class='btn-action btn btn-danger btn-delete' title='Delete'><i class='fa fa-trash-o'></i></button>";
                $view = "";
				if (!empty($access_control)) {
					if ($access_control[$userinfo['user_level_id']][$segment] == "v"){
						return $view;
					} else if ($access_control[$userinfo['user_level_id']][$segment] == "vu"){
						return $view." ".$edit;
					} else if ($access_control[$userinfo['user_level_id']][$segment] == "a"){
						return $view." ".$edit." ".$delete;
					}
				} else {
					return "";
				}
            })
            ->rawColumns(['action'])
            ->make(true);
	}
 	
}
