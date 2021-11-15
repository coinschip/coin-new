<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Coin\HasFeaturedPhoto;

class Post extends Model
{
    use HasFactory;
    use HasFeaturedPhoto;
	use SoftDeletes;

	/**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
		'article',
		'user_id',
	];

	/**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'featured_photo_url',
    ];
}
