<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PagesLanguage extends Model {
	protected $table = 'pages_language';
	protected $hidden = ['created_at', 'updated_at'];

	public function pages()
	{
		return $this->belongsTo('App\Model\Pages', 'pages_id');
	}
    
}