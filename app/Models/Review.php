<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{

	protected $fillable = [
		'comment',
		'book_id'
	];
    protected $primaryKey = 'review_id';
	public $timestamps = false;

	public function book()
	{
		return $this->belongsTo(Book::class, 'book_id');
	}
}
