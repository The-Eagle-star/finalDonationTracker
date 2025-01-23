<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'date',
        'cause_name',
        'category',
        'notes',
        'category_id', // Foreign key for the category
        'charity_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function charity()
{
    return $this->belongsTo(Charity::class);
}

}
