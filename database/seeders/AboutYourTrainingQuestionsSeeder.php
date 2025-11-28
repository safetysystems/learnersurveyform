<?php

namespace Database\Seeders;

use App\Models\AboutYourTrainingQuestion;
use Illuminate\Database\Seeder;

class AboutYourTrainingQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Codes here match the official AQTF learner questionnaire (LQxx) codes,
        // while display_order controls the order they appear on the form.
        $questions = [
            ['code' => 'LQ21', 'text' => 'I developed the skills expected from this training.'],
            ['code' => 'LQ23', 'text' => 'I identified ways to build on my current knowledge and skills.'],
            ['code' => 'LQ18', 'text' => 'The training focused on relevant skills.'],
            ['code' => 'LQ24', 'text' => 'I developed the knowledge expected from this training.'],
            ['code' => 'LQ19', 'text' => 'The training prepared me well for work.'],
            ['code' => 'LQ32', 'text' => 'I set high standards for myself in this training.'],
            ['code' => 'LQ20', 'text' => 'The training had a good mix of theory and practice.'],
            ['code' => 'LQ34', 'text' => 'I looked for my own resources to help me learn.'],
            ['code' => 'LQ5', 'text' => 'Overall, I am satisfied with the training.'],
            ['code' => 'LQ7', 'text' => 'I would recommend the training organisation to others.'],
            ['code' => 'LQ29', 'text' => 'Training organisation staff respected my background and needs.'],
            ['code' => 'LQ33', 'text' => 'I pushed myself to understand things I found confusing.'],
            ['code' => 'LQ3', 'text' => 'Trainers had an excellent knowledge of the subject content.'],
            ['code' => 'LQ8', 'text' => 'I received useful feedback on my assessments.'],
            ['code' => 'LQ10', 'text' => 'The way I was assessed was a fair test of my skills and knowledge.'],
            ['code' => 'LQ22', 'text' => 'I learned to work with people.'],
            ['code' => 'LQ17', 'text' => 'The training was at the right level of difficulty for me.'],
            ['code' => 'LQ16', 'text' => 'The amount of work I had to do was reasonable.'],
            ['code' => 'LQ9', 'text' => 'Assessments were based on realistic activities.'],
            ['code' => 'LQ12', 'text' => 'It was always easy to know the standards expected.'],
            ['code' => 'LQ28', 'text' => 'Training facilities and materials were in good condition.'],
            ['code' => 'LQ13', 'text' => 'I usually had a clear idea of what was expected of me.'],
            ['code' => 'LQ4', 'text' => 'Trainers explained things clearly.'],
            ['code' => 'LQ31', 'text' => 'The training organisation had a range of services to support learners.'],
            ['code' => 'LQ25', 'text' => 'I learned to plan and manage my work.'],
            ['code' => 'LQ27', 'text' => 'The training used up-to-date equipment, facilities and materials.'],
            ['code' => 'LQ35', 'text' => 'I approached trainers if I needed help.'],
            ['code' => 'LQ2', 'text' => 'Trainers made the subject as interesting as possible.'],
            ['code' => 'LQ6', 'text' => 'I would recommend the training to others.'],
            ['code' => 'LQ11', 'text' => 'The training organisation gave appropriate recognition of existing knowledge and skills.'],
            ['code' => 'LQ26', 'text' => 'Training resources were available when I needed them.'],
            ['code' => 'LQ15', 'text' => 'I was given enough material to keep up my interest.'],
            ['code' => 'LQ30', 'text' => 'The training was flexible enough to meet my needs.'],
            ['code' => 'LQ1', 'text' => 'Trainers encouraged learners to ask questions.'],
            ['code' => 'LQ14', 'text' => 'Trainers made it clear right from the start what they expected from me.'],
        ];

        foreach ($questions as $index => $question) {
            AboutYourTrainingQuestion::updateOrCreate(
                ['question_code' => $question['code']],
                [
                    'question' => $question['text'],
                    'display_order' => $index + 1,
                ]
            );
        }
    }
}
