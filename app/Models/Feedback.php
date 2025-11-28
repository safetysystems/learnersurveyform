<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'course_id',
        'venue_id',
        'course_date',
        'trainer_name',
        'has_learner_survey',
        'is_scanned',
        'response_code'
    ];

    protected $casts = [
        'course_date' => 'date',
        'has_learner_survey' => 'bool',
        'is_scanned' => 'bool',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function learnerQuestionnaireForms()
    {
        return $this->hasMany(LearnerQuestionnaireForm::class);
    }
}
