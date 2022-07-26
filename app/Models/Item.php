<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Item extends Model
{
    use HasFactory;
    protected $fillable=['user_id','sold','amount','cert_no','signed_by','name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
