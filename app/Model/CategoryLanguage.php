<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryLanguage extends Model {
	protected $table = 'category_language';
	protected $hidden = ['created_at', 'updated_at'];

	public function category()
	{
		return $this->belongsTo('App\Model\Category', 'category_id');
	}
    
}