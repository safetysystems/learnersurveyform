<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearnerQuestionnaireAnswer extends Model
{
    protected $fillable = [
        'learner_questionnaire_form_id',
        'question_id',
        'answer',
    ];

    public function form()
    {
        return $this->belongsTo(LearnerQuestionnaireForm::class, 'learner_questionnaire_form_id');
    }

    public function question()
    {
        return $this->belongsTo(AboutYourTrainingQuestion::class, 'question_id');
    }
}

