<?php 

namespace App\Entities;
 
use Illuminate\Database\Eloquent\Model;


class Person extends Model {
	protected $table='base_person';
	protected $primaryKey = 'pid';
	
	public $timestamps = false;
	protected $guarded = array();
}