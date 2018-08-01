<?php


namespace App\Http\Controllers\Backend;

use Session;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Model\Setting;
use App\Model\Language;
use Illuminate\Support\Facades\Redirect;
use Image;

class SettingController extends Controller {
	public function index(Request $request) {
        $language = Language::all();
        $default_language = Language::where('default',1)->first();
		return view ('backend.setting',['language' => $language, 'default_language' => $default_language]);
	}
	
    public function update(Request $request)
    {
		$insert = Setting::find(2);
		if (empty($request->logo)){
			if (empty($request->default_logo)){
				$insert->value = '';
			}
		} else {
			$logoName = 'logo.'.$request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('img'), $logoName);
            // $img = Image::make($request->logo);
            // $img->resize(200, null, function ($constraint) {
            //     $constraint->aspectRatio();
            // });            
            // $img->save('img/logo.'.$request->logo->getClientOriginalExtension());
			$insert->value = 'img/logo.'.$request->logo->getClientOriginalExtension();
        }
        $insert->save();

        $data = Setting::orderBy('id', 'DESC')->first();
		for ($i=1;$i<=$data['id'];$i++){
			if (isset($_POST[$i])){
				$insert = Setting::find($i);
				$insert->value = $_POST[$i];
				$insert->user_modified = Session::get('userinfo')['user_id'];
				$insert->save();
			}
        }
        
        //LANGUAGE
        $multi = 0;
        if (isset($_POST["multi_language"])){
            $multi = 1;
            $reset_active = Language::where('default','!=',1)->update(['active' => 0]);
            if (!(empty($_POST['multi_language_checkbox'])))
            {
                foreach($_POST['multi_language_checkbox'] as $item)
                { 
                    $update_active = Language::where('id',$item)->update(['active' => 1]);
                } 
            }
        }
        $reset_default = Language::where('id','>',0)->update(['default' => 0]);
        $update_default = Language::where('id',$request->default_language)->update(['default' => 1,'active' => 1]);

        //SET LANGUAGE
        $default_language = Language::where('default',1)->first();
        if ($multi == 1){
            $active_language = Language::where('active',1)->orderBy('id','ASC')->get();
        } else {
            $active_language = Language::where('default',1)->get();
        }
        Session::put ('default_language',$default_language);
        Session::put ('active_language',$active_language);

        $insert = Setting::find(5);
        $insert->value = $multi;
        $insert->save();

		return Redirect::to('/backend/setting')->with('success', "Data saved successfully")->with('mode', 'success');
    }
    
	public function check_language() {
        $code = "";
		if (isset($_POST["code"])){
            $code = $_POST["code"];
			$post = Language::where('code',$code)->count();
			if ($post > 0){
				echo 1;
			} else{
				echo 0;
			}
		}
    }
    
	public function insert_language() {
        $code = "";
        if (isset($_POST["code"])){
            $code = $_POST["code"];
        }
        $name = "";
        if (isset($_POST["name"])){
            $name = $_POST["name"];
        }

        $data = new Language();
        $data->code = strtoupper($code);
        $data->name = ucfirst(strtolower($name));
        $data->active = 1;
        $data->default = 0;
        $data->user_modified = Session::get('userinfo')['user_id'];
        $data->save();
        $id = $data->id;
        echo $id;
	}

    
}