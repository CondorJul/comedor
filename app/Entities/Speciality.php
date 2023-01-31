<?php 

namespace App\Entities;
 
use Illuminate\Database\Eloquent\Model;

class Speciality extends Model {

	protected $primaryKey = 'escid';

	protected $table='base_speciality';
	
	public $timestamps = false;
	protected $guarded = array();

	/*protected $fillable = ['id', 'type', 'soup','second', 'drink', 'dessert','fruit'];

	public static $rules = array(
    'id'              => 'required',
    'type'                  => 'required',
    'soup'                 => 'required',
    'second'              => 'required',
    'drink'					=>'required',
	'dessert'				=>'required',
	'fruit'					=>'required',
);*/
}