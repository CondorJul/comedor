<?php 

namespace App\Entities;
 
use Illuminate\Database\Eloquent\Model;

class Horary extends Model {

	protected $primaryKey = 'id';

	protected $table='timetable';
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