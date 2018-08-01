<?php

namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Model\Pages;
use App\Model\PagesLanguage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Datatables;
use Carbon\Carbon;

class PagesController extends Controller
{
    public function generateSlug($title, $id = 0 , $model = false)
    {
		preg_match('/^(?>\S+\s*){1,10}/', $title, $match);
        $slug = str_slug(trim($match[0]));
        $post = [];
        $post = Pages::where('slug', '=', $slug)->where('id', '!=', $id)->count();
        if($post > 0) {
            return $slug . '-' . strtotime(Carbon::now());
        } else {
            return $slug;
        }
    }
        
    public function index()
    {
        //
		return view ('backend.pages.index');
    }

    public function create()
    {
        //
		return view ('backend.pages.update');
    }

    public function store(Request $request)
    {
        //
        $default_language = Session::get('default_language');
		$data = new Pages();
        $data->featured_image = $request->featured_image;
        $data->slug = $this->generateSlug($_POST['judul_'.$default_language->code]);
        $data->active = $request->active;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
            $id = $data->id;
            $active_language = Session::get('active_language');
            foreach ($active_language as $language):
                $data = new PagesLanguage();
                $data->pages_id = $id;
                $data->judul = $_POST['judul_'.$language->code];
                $data->caption_img = $_POST['caption_img_'.$language->code];;
                $data->detail = $_POST['detail_'.$language->code];;
                $data->language_code = $language->code;
                $data->save();
            endforeach;
			return Redirect::to('/backend/pages/')->with('success', "Data saved successfully")->with('mode', 'success');
		}

    }

    public function edit($id)
    {
        //
		$data = Pages::where('id', $id)->where('active', '!=', 0)->get();
		if ($data->count() > 0){
            $data_language = PagesLanguage::where('pages_id', $id)->get();
			return view ('backend.pages.update', ['data' => $data, 'data_language' => $data_language]);
		}
    }

    public function update(Request $request, $id)
    {
        //
        $default_language = Session::get('default_language');
		$data = Pages::find($id);
        $data->featured_image = $request->featured_image;
        $data->slug = $this->generateSlug($_POST['judul_'.$default_language->code], $id);
        $data->active = $request->active;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
            $active_language = Session::get('active_language');
            foreach ($active_language as $language):
                $language_exist = PagesLanguage::where('pages_id', $id)->where('language_code', $language->code)->count();
                if ($language_exist < 1){
                    //INSERT BARU
                    $data = new PagesLanguage();
                    $data->pages_id = $id;
                    $data->judul = $_POST['judul_'.$language->code];
                    $data->caption_img = $_POST['caption_img_'.$language->code];;
                    $data->detail = $_POST['detail_'.$language->code];;
                    $data->language_code = $language->code;
                    $data->save();
                } else {
                    //UPDATE
                    $check_language_id = PagesLanguage::where('pages_id', $id)->where('language_code', $language->code)->first();
                    $data = PagesLanguage::find($check_language_id->id);
                    $data->judul = $_POST['judul_'.$language->code];
                    $data->caption_img = $_POST['caption_img_'.$language->code];;
                    $data->detail = $_POST['detail_'.$language->code];;
                    $data->save();
                }
            endforeach;
			return Redirect::to('/backend/pages/')->with('success', "Data saved successfully")->with('mode', 'success');
		}
    }

    public function destroy(Request $request, $id)
    {
        //
		$data = Pages::find($id);
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
        $data = Pages::select('pages.*','pages_language.judul')
                ->leftJoin('pages_language','pages.id','=','pages_language.pages_id')
                ->where('pages_language.language_code','=', $default_language->code)
                ->where('pages.active', '!=', 0);
        return Datatables::of($data)
			->addColumn('action', function ($data) {
				$userinfo = Session::get('userinfo');
				$access_control = Session::get('access_control');
				$segment =  \Request::segment(2);
				$url_edit = url('backend/pages/'.$data->id.'/edit');
                $url = url('backend/pages/'.$data->id);
                $url_view = url('pages/'.$data->slug);
				$view = "<a class='btn-action btn btn-primary' target='_blank' href='".$url_view."' title='View'><i class='fa fa-eye'></i></a>";
				$edit = "<a class='btn-action btn btn-info btn-edit' href='".$url_edit."' title='Edit'><i class='fa fa-edit'></i></a>";
                $delete = "<button data-url='".$url."' onclick='deleteData(this)' class='btn-action btn btn-danger btn-delete' title='Delete'><i class='fa fa-trash-o'></i></button>";
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
