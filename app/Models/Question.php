<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['survey_id', 'question_text', 'question_type', 'options'];

    // Define the relationship with Survey
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}