<?php 

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class TokenUsersFirebase extends Model {

	protected $primaryKey = 'token';

	protected $table='token_users_firebase';
	public $timestamps = false;
	protected $guarded = array();


}