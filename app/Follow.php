<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model {
	protected $fillable = [
		'user_id',
		'followed_type',
		'followed_id',
	];
	// public function user() {
	// 	return $this->belongsTo(\App\User::class);
	// }
	// public function category() {
	// 	return $this->belongsTo(\App\Category::class, 'follwing_collection_id');
	// }
	// public function collection() {
	// 	return $this->belongsTo(\App\Collection::class, 'follwing_category_id');
	// }
	// public function following() {
	// 	return $this->belongsTo(\App\User::class, 'follwing_user_id');
	// }
	public function followed() {
		return $this->morphTo();
	}
}
