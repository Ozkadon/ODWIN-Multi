<?php

namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Model\Category;
use App\Model\CategoryLanguage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Datatables;

class CategoryController extends Controller
{
       
    public function index()
    {
        //
		return view ('backend.category.index');
    }

    public function create()
    {
        //
		return view ('backend.category.update');
    }

    public function store(Request $request)
    {
        //
        $default_language = Session::get('default_language');
		$data = new Category();
        $data->active = $request->active;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
            $id = $data->id;
            $active_language = Session::get('active_language');
            foreach ($active_language as $language):
                $data = new CategoryLanguage();
                $data->category_id = $id;
                $data->name = $_POST['name_'.$language->code];
                $data->language_code = $language->code;
                $data->save();
            endforeach;
			return Redirect::to('/backend/blog-category/')->with('success', "Data saved successfully")->with('mode', 'success');
		}

    }

    public function show($id)
    {
        //
        $default_language = Session::get('default_language');
        $data = Category::select('category.*','category_language.name')->with(['user_modify'])
                ->leftJoin('category_language','category.id','=','category_language.category_id')
                ->where('category_language.language_code','=', $default_language->code)
                ->where('category.id', $id)
                ->get();
		if ($data->count() > 0){
			return view ('backend.category.view', ['data' => $data]);
		}
    }

    public function edit($id)
    {
        //
		$data = Category::where('id', $id)->where('active', '!=', 0)->get();
		if ($data->count() > 0){
            $data_language = CategoryLanguage::where('category_id', $id)->get();
			return view ('backend.category.update', ['data' => $data, 'data_language' => $data_language]);
		}
    }

    public function update(Request $request, $id)
    {
        //
        $default_language = Session::get('default_language');
		$data = Category::find($id);
        $data->active = $request->active;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
            $active_language = Session::get('active_language');
            foreach ($active_language as $language):
                $language_exist = CategoryLanguage::where('category_id', $id)->where('language_code', $language->code)->count();
                if ($language_exist < 1){
                    //INSERT BARU
                    $data = new CategoryLanguage();
                    $data->category_id = $id;
                    $data->name = $_POST['name_'.$language->code];
                    $data->language_code = $language->code;
                    $data->save();
                } else {
                    //UPDATE
                    $check_language_id = CategoryLanguage::where('category_id', $id)->where('language_code', $language->code)->first();
                    $data = CategoryLanguage::find($check_language_id->id);
                    $data->name = $_POST['name_'.$language->code];
                    $data->save();
                }
            endforeach;
			return Redirect::to('/backend/blog-category/')->with('success', "Data saved successfully")->with('mode', 'success');
		}
    }

    public function destroy(Request $request, $id)
    {
        //
		$data = Category::find($id);
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
        $data = Category::select('category.*','category_language.name')
                ->leftJoin('category_language','category.id','=','category_language.category_id')
                ->where('category_language.language_code','=', $default_language->code)
                ->where('category.active', '!=', 0);
        return Datatables::of($data)
			->addColumn('action', function ($data) {
				$userinfo = Session::get('userinfo');
				$access_control = Session::get('access_control');
				$segment =  \Request::segment(2);
				$url_edit = url('backend/blog-category/'.$data->id.'/edit');
                $url = url('backend/blog-category/'.$data->id);
				$view = "<a class='btn-action btn btn-primary btn-view' href='".$url."' title='View'><i class='fa fa-eye'></i></a>";
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
