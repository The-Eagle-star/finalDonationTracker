<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Charity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'logo',
        'short_description',
        'total_donations',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
