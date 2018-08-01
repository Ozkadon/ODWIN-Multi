<?php

namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Model\Blog;
use App\Model\BlogLanguage;
use App\Model\Category;
use App\Model\CategoryLanguage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Datatables;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function generateSlug($title, $id = 0 , $model = false)
    {
		preg_match('/^(?>\S+\s*){1,10}/', $title, $match);
        $slug = str_slug(trim($match[0]));
        $post = [];
        $post = Blog::where('slug', '=', $slug)->where('id', '!=', $id)->count();
        if($post > 0) {
            return $slug . '-' . strtotime(Carbon::now());
        } else {
            return $slug;
        }
    }
        
    public function index()
    {
        //
		return view ('backend.blog.index');
    }

    public function create()
    {
        //
        $default_language = Session::get('default_language');
        $category = Category::leftJoin('category_language','category.id','=','category_language.category_id')
                ->where('category_language.language_code','=', $default_language->code)
                ->where('category.active', '!=', 0)
                ->pluck('category_language.name','category.id');
		return view ('backend.blog.update',['category' => $category]);
    }

    public function store(Request $request)
    {
        //
        $default_language = Session::get('default_language');
        $data = new Blog();
        $data->category_id = $request->category_id;
        $data->featured_image = $request->featured_image;
        $data->slug = $this->generateSlug($_POST['judul_'.$default_language->code]);
        $data->active = $request->active;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
            $id = $data->id;
            $active_language = Session::get('active_language');
            foreach ($active_language as $language):
                $data = new BlogLanguage();
                $data->blog_id = $id;
                $data->judul = $_POST['judul_'.$language->code];
                $data->caption_img = $_POST['caption_img_'.$language->code];;
                $data->detail = $_POST['detail_'.$language->code];;
                $data->language_code = $language->code;
                $data->save();
            endforeach;
			return Redirect::to('/backend/blog-content/')->with('success', "Data saved successfully")->with('mode', 'success');
		}

    }

    public function edit($id)
    {
        //
        $default_language = Session::get('default_language');
        $category = Category::leftJoin('category_language','category.id','=','category_language.category_id')
                ->where('category_language.language_code','=', $default_language->code)
                ->where('category.active', '!=', 0)
                ->pluck('category_language.name','category.id');
		$data = Blog::where('id', $id)->where('active', '!=', 0)->get();
		if ($data->count() > 0){
            $data_language = BlogLanguage::where('blog_id', $id)->get();
			return view ('backend.blog.update', ['data' => $data, 'data_language' => $data_language, 'category' => $category]);
		}
    }

    public function update(Request $request, $id)
    {
        //
        $default_language = Session::get('default_language');
        $data = BLog::find($id);
        $data->category_id = $request->category_id;
        $data->featured_image = $request->featured_image;
        $data->slug = $this->generateSlug($_POST['judul_'.$default_language->code], $id);
        $data->active = $request->active;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
            $active_language = Session::get('active_language');
            foreach ($active_language as $language):
                $language_exist = BlogLanguage::where('blog_id', $id)->where('language_code', $language->code)->count();
                if ($language_exist < 1){
                    //INSERT BARU
                    $data = new BlogLanguage();
                    $data->blog_id = $id;
                    $data->judul = $_POST['judul_'.$language->code];
                    $data->caption_img = $_POST['caption_img_'.$language->code];;
                    $data->detail = $_POST['detail_'.$language->code];;
                    $data->language_code = $language->code;
                    $data->save();
                } else {
                    //UPDATE
                    $check_language_id = BlogLanguage::where('blog_id', $id)->where('language_code', $language->code)->first();
                    $data = BlogLanguage::find($check_language_id->id);
                    $data->judul = $_POST['judul_'.$language->code];
                    $data->caption_img = $_POST['caption_img_'.$language->code];;
                    $data->detail = $_POST['detail_'.$language->code];;
                    $data->save();
                }
            endforeach;
			return Redirect::to('/backend/blog-content/')->with('success', "Data saved successfully")->with('mode', 'success');
		}
    }

    public function destroy(Request $request, $id)
    {
        //
		$data = Blog::find($id);
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
        $data = Blog::select('blog.*','blog_language.judul', 'category_language.name')
                ->leftJoin('blog_language','blog.id', '=','blog_language.blog_id')
                ->leftJoin('category_language','blog.category_id', '=','category_language.category_id')
                ->where('blog_language.language_code','=', $default_language->code)
                ->where('category_language.language_code','=', $default_language->code)
                ->where('blog.active', '!=', 0);
        return Datatables::of($data)
			->addColumn('action', function ($data) {
				$userinfo = Session::get('userinfo');
				$access_control = Session::get('access_control');
				$segment =  \Request::segment(2);
				$url_edit = url('backend/blog-content/'.$data->id.'/edit');
                $url = url('backend/blog-content/'.$data->id);
                $url_view = url('blog/'.$data->slug);
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
