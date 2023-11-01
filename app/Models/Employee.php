<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_email',
        'company',
        'email',
        'phone',
        'created_at',
        'updated_at',
    ];
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company');
    }
}
