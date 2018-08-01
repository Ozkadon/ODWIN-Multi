<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model {
	protected $table = 'pages';
	protected $hidden = ['created_at', 'updated_at'];
	
	public function user_modify()
	{
		return $this->belongsTo('App\Model\User', 'user_modified');
	}

	public function media_image_1()
	{
		return $this->belongsTo('App\Model\MediaLibrary', 'featured_image');
	}
    
}