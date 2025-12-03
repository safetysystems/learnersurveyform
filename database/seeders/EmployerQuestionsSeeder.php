<?php

namespace Database\Seeders;

use App\Models\AboutYourTrainingQuestion;
use Illuminate\Database\Seeder;

class EmployerQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Codes and wording follow the AQTF Employer Questionnaire (EQxx),
        // in the order they appear on the paper form.
        $questions = [
            ['code' => 'EQ19', 'text' => 'Trainers were effective in their teaching.'],
            ['code' => 'EQ17', 'text' => 'Trainers had good knowledge and experience of the industry.'],
            ['code' => 'EQ21', 'text' => 'Trainers were able to relate material to the workplace.'],
            ['code' => 'EQ12', 'text' => 'Overall, we are satisfied with the training.'],
            ['code' => 'EQ14', 'text' => 'We would recommend the training to others.'],
            ['code' => 'EQ18', 'text' => 'Assessments were based on realistic activities.'],
            ['code' => 'EQ15', 'text' => 'The training organisation gave appropriate recognition of existing knowledge and skills.'],
            ['code' => 'EQ4',  'text' => 'Assessment was at an appropriate standard.'],
            ['code' => 'EQ9',  'text' => 'The training focused on relevant skills.'],
            ['code' => 'EQ27', 'text' => 'The training prepared employees well for work.'],
            ['code' => 'EQ22', 'text' => 'The training had a good mix of theory and practice.'],
            ['code' => 'EQ13', 'text' => 'We would recommend the training organisation to others.'],
            ['code' => 'EQ20', 'text' => 'The training was an effective investment.'],
            ['code' => 'EQ6',  'text' => 'The training reflected current practice.'],
            ['code' => 'EQ11', 'text' => 'The training was effectively integrated into our organisation.'],
            ['code' => 'EQ10', 'text' => 'Our employees gained the skills they needed from this training.'],
            ['code' => 'EQ24', 'text' => 'The training has helped our employees work with people.'],
            ['code' => 'EQ26', 'text' => 'The training helped employees identify how to build on their current knowledge and skills.'],
            ['code' => 'EQ28', 'text' => 'Our employees gained the knowledge they needed from this training.'],
            ['code' => 'EQ29', 'text' => 'The training prepared our employees for the demands of work.'],
            ['code' => 'EQ1',  'text' => 'The training used up-to-date equipment, facilities and materials.'],
            ['code' => 'EQ5',  'text' => 'The training resources were appropriate for learner needs.'],
            ['code' => 'EQ25', 'text' => 'Training resources and equipment were in good condition.'],
            ['code' => 'EQ23', 'text' => 'The training organisation acted on feedback from employers.'],
            ['code' => 'EQ7',  'text' => 'The training organisation developed customised programs.'],
            ['code' => 'EQ16', 'text' => 'The way employees were assessed was a fair test of their skills and knowledge.'],
            ['code' => 'EQ3',  'text' => 'The training organisation was flexible enough to meet our needs.'],
            ['code' => 'EQ2',  'text' => 'The training organisation dealt satisfactorily with any issues or complaints.'],
            ['code' => 'EQ8',  'text' => 'The training organisation provided good support for workplace training and assessment.'],
            ['code' => 'EQ30', 'text' => 'The training organisation clearly explained what was expected from employers.'],
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

