<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CoinVote extends Model
{
    use HasFactory;
	use SoftDeletes;

	/**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
		'coin_id',
		'user_id',
		'ip_address',
		'user_agent',
	];
}
