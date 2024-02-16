<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subcategory extends Model
{
    use HasFactory;
    protected $table='subcategory';
    public function category(){
        return $this->belongsTo(category::class);
    }
}
