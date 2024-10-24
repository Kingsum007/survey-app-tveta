<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description'];

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
