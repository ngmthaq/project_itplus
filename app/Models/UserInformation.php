<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use HasFactory;

    // Table
    protected $table = 'user_informations';

    // Fillable
    protected $fillable = [
        'user_id',
        'is_male',
        'dob',
        'address',
    ];

    // Belong to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
