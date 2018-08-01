<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
	protected $table = 'category';
	protected $hidden = ['created_at', 'updated_at'];
	
	public function user_modify()
	{
		return $this->belongsTo('App\Model\User', 'user_modified');
	}
    
}