<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model {
	protected $fillable = [
		'user_id',
		'faved_id',
		'faved_type',
	];

	public function comment() {
		return $this->belongsTo(\App\Comment::class);
	}
	public function faved() {
		return $this->morphTo();
	}
}
