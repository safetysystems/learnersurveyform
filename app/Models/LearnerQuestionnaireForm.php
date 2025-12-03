<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearnerQuestionnaireForm extends Model
{
    protected $fillable = [
        'feedback_id',
        'is_employer',
    ];

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }

    public function answers()
    {
        return $this->hasMany(LearnerQuestionnaireAnswer::class);
    }

    public function demographics()
    {
        return $this->hasOne(LearnerQuestionnaireDemographic::class, 'learner_questionnaire_form_id');
    }
}
