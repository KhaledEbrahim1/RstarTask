<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
        'category_id',
        'partition_id',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function partition()
    {
        return $this->belongsTo(Partition::class);
    }
}
