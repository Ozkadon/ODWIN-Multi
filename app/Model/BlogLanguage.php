<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BlogLanguage extends Model {
	protected $table = 'blog_language';
	protected $hidden = ['created_at', 'updated_at'];

	public function blog()
	{
		return $this->belongsTo('App\Model\Blog', 'blog_id');
	}
    
}