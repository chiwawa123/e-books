<?php

namespace App\Models;

use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    protected $table = 'tbl_books';
	protected $primaryKey = 'book_id';
	public $timestamps = false;

	protected $fillable = [
		'title',
		'author',
		'year',
		'description',
		'cover_image'
	];


    public function reviews()
    {
        return $this->hasMany(Review::class, 'book_id', 'book_id'); // Ensure correct foreign key mapping
    }
}
