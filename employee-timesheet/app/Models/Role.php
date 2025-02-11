<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function getRoleAttribute()
{
    return $this->attributes['role'] ?? '2'; 
}

    protected $fillable = ['name'];
}
