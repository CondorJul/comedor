<?php 

namespace App\Entities;
 
use Illuminate\Database\Eloquent\Model;

class Audit extends Model {

	protected $primaryKey = 'id';

	protected $table='audits';
	
	public $timestamps = true;
	protected $guarded = array();

	protected $fillable= [
		'user_agent', 
		'method',
		'url', 
		'ip',
		'name_table',
		'key_word',
		'subject',
		'data_old',
		'data_new', 
		'created_by',
		'updated_by'
	];

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