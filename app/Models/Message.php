<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	//protected $table = 'messages';

	public $table = 'messages';
    public $primaryKey = 'msg_id';



    public $fillable = [
        'incoming_msg_id',
        'outgoing_msg_id',
        'msg'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'incoming_msg_id' => 'integer',
        'outgoing_msg_id' => 'integer',
        'msg' => 'text'
    ];

	// public $timestamps = true;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	// protected $fillable = [
	// 	'incoming_msg_id', 'outgoing_msg_id','msg',
	// ];
}