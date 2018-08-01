<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PhotosLanguage extends Model {
	protected $table = 'photos_language';
	protected $hidden = ['created_at', 'updated_at'];

	public function photos()
	{
		return $this->belongsTo('App\Model\Photos', 'photos_id');
	}
    
}