<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = ['survey_id', 'answers'];

    // Define the relationship with Survey
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
    public function answers()
    {
        return json_decode($this->answers, true);
    }
     // Accessor for answers
     public function getAnswersAttribute($value)
     {
         return json_decode($value, true);
     }
}
