<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsModel extends Model
{
    use HasFactory;
    protected $table = 'news';
    protected $guarded = [];
    
    public function categories_id()
    {
        return $this->belongsTo(CategoryModel::class, 'categories_id','id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by','id');
    }

    public function comments()
    {
        return $this->hasMany(CommentModel::class, 'news_id');
    }

}
