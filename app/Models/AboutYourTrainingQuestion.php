<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutYourTrainingQuestion extends Model
{
    protected $fillable = [
        'question_code',
        'question',
        'display_order',
    ];

    public function answers()
    {
        return $this->hasMany(LearnerQuestionnaireAnswer::class, 'question_id');
    }
}
