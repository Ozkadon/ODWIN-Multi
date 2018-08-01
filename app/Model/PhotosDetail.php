<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PhotosDetail extends Model {
	protected $table = 'photos_detail';
	protected $hidden = ['created_at', 'updated_at'];
	
	public function photos()
	{
		return $this->belongsTo('App\Model\Photos', 'photos_id');
	}

    public function media_image_1()
	{
		return $this->belongsTo('App\Model\MediaLibrary', 'image_id');
	}
    
}