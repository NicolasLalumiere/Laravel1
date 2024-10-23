<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $fillable = ['voyage_id','type'];
    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
