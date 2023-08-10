<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPageModel extends Model
{
    use HasFactory;
    protected $table = 'custom_pages';
    protected $guarded = [];

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by','id');
    }
}
