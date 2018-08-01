<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model {
	protected $table = 'contact_us';
	protected $hidden = ['created_at', 'updated_at'];
	
}