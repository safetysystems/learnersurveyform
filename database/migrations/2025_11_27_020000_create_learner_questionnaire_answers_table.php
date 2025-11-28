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
        Schema::create('learner_questionnaire_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learner_questionnaire_form_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedTinyInteger('answer');
            $table->timestamps();

            $table->foreign('learner_questionnaire_form_id', 'lqa_form_fk')
                ->references('id')
                ->on('learner_questionnaire_forms')
                ->onDelete('cascade');

            $table->foreign('question_id', 'lqa_question_fk')
                ->references('id')
                ->on('about_your_training_questions')
                ->onDelete('cascade');

            $table->unique(['learner_questionnaire_form_id', 'question_id'], 'lqa_form_question_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learner_questionnaire_answers');
    }
};
