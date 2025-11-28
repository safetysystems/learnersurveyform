<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearnerQuestionnaireDemographic extends Model
{
    protected $fillable = [
        'learner_questionnaire_form_id',
        'best_aspects',
        'needs_improvement',
        'qualification_full_title',
        'qualification_level',
        'training_broad_field',
        'training_start_month',
        'training_start_year',
        'is_apprenticeship_or_traineeship',
        'has_recognition_of_prior_learning',
        'speaks_language_other_than_english_at_home',
        'is_permanent_resident_or_citizen',
        'has_disability_or_impairment',
        'sex_code',
        'age_band_code',
        'atsi_origin_code',
        'postcode',
    ];

    public function form()
    {
        return $this->belongsTo(LearnerQuestionnaireForm::class, 'learner_questionnaire_form_id');
    }
}

