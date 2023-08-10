<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $guarded = [];
    
    public function total_news()
    {
        return $this->hasMany(NewsModel::class, 'categories_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by','id');
    }
}
