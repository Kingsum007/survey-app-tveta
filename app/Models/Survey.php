<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image', // Add image to fillable
    ];
    

    // Define the relationship with Question
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function responses()
{
    return $this->hasMany(Response::class);
}

}
