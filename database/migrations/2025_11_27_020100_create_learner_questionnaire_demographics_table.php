<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('learner_questionnaire_demographics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learner_questionnaire_form_id');

            // Open text questions
            $table->text('best_aspects')->nullable();
            $table->text('needs_improvement')->nullable();
            $table->string('qualification_full_title')->nullable();

            // Training details / codes from the form
            $table->unsignedTinyInteger('qualification_level')->nullable();
            $table->unsignedTinyInteger('training_broad_field')->nullable();
            $table->unsignedTinyInteger('training_start_month')->nullable();
            $table->unsignedSmallInteger('training_start_year')->nullable();

            // Yes / No flags
            $table->boolean('is_apprenticeship_or_traineeship')->nullable();
            $table->boolean('has_recognition_of_prior_learning')->nullable();
            $table->boolean('speaks_language_other_than_english_at_home')->nullable();
            $table->boolean('is_permanent_resident_or_citizen')->nullable();
            $table->boolean('has_disability_or_impairment')->nullable();

            // About you (coded values match the paper form options)
            $table->unsignedTinyInteger('sex_code')->nullable();
            $table->unsignedTinyInteger('age_band_code')->nullable();
            $table->unsignedTinyInteger('atsi_origin_code')->nullable();

            // Location
            $table->string('postcode', 10)->nullable();

            $table->timestamps();

            $table->foreign('learner_questionnaire_form_id', 'lqd_form_fk')
                ->references('id')
                ->on('learner_questionnaire_forms')
                ->onDelete('cascade');

            $table->unique('learner_questionnaire_form_id', 'lqd_form_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learner_questionnaire_demographics');
    }
};
