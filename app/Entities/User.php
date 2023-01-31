<?php 

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class User extends Model {

	protected $primaryKey = 'uid';

	protected $table='base_users';
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

	public function person()
    {
        return $this->belongsTo(Person::class,'pid','numdoc');
    }
}