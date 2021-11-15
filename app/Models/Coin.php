<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Coin\HasLogo;

class Coin extends Model
{
    use HasFactory;
	use HasLogo;
	use SoftDeletes;

	/**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
		'name',
		'symbol',
		'price',
		'yesterday',
		'capital',
		'launched_at',
		'user_id',
	];

	/**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'logo_url',
    ];
}
