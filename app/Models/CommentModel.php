<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $guarded = [];
    
    public function news_id()
    {
        return $this->belongsTo(NewsModel::class, 'news_id','id');
    }
}
