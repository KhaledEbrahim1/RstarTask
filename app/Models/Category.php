<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
    ];
   public function items()
   {
     return $this->hasMany(Item::class);
   }

   public function partitions()
   {
     return $this->hasMany(Partition::class);
   }

}
