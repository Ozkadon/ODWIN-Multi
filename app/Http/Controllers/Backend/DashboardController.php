<?php
namespace App\Http\Controllers\Backend;

use Session;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Model\User;
use App\Model\Blog;
use Carbon\Carbon;
 
class DashboardController extends Controller {
	public function dashboard(Request $request) {
        $today = Carbon::today();
        $new_user = User::where('active',1)->where('created_at', '>', $today->subDays(7))->count();
        $total_user = User::where('active',1)->count();
        $new_blog = Blog::where('active',1)->where('created_at', '>', $today->subDays(7))->count();
        $total_blog = Blog::where('active',1)->count();
        $data['new_user'] = $new_user;
        $data['total_user'] = $total_user;
        $data['new_blog'] = $new_blog;
        $data['total_blog'] = $total_blog;

		return view ('backend.dashboard',['data' => $data]);
	}
}