<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;


public function users() {
    return $this->belongToMany(User::class)->withPivot('total_score');
}
};