<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voyage extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'pays','jours', 'photo'];

    public function transports()
    {
        return $this ->hasMany(Transport::class);
    }  

    public function user()
    {
        return $this ->belongsTo(User::class);
    }  

}


