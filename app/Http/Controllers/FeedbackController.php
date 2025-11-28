<?php

namespace App\Http\Controllers;

use App\Models\AboutYourTrainingQuestion;
use App\Models\Course;
use App\Models\Feedback;
use App\Models\LearnerQuestionnaireAnswer;
use App\Models\LearnerQuestionnaireDemographic;
use App\Models\LearnerQuestionnaireForm;
use App\Models\Venue;
use App\Services\OpenAiSurveyParser;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FeedbackController extends Controller
{
    /**
     * Show a list of feedback forms.
     */
    public function index(Request $request)
    {
        $query = Feedback::with(['course', 'venue'])
            ->withCount('learnerQuestionnaireForms')
            ->orderByDesc('created_at')
            ->orderByDesc('id');

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->input('course_id'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('course_date', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('course_date', '<=', $request->input('date_to'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('trainer_name', 'like', '%' . $search . '%')
                    ->orWhereHas('course', function ($qc) use ($search) {
                        $qc->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('venue', function ($qv) use ($search) {
                        $qv->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $feedbackItems = $query->get();
        $courses = Course::orderBy('name')->get();

        $stats = [
            'total_feedback' => Feedback::count(),
            'total_responses' => LearnerQuestionnaireForm::count(),
            'total_questions' => AboutYourTrainingQuestion::count(),
        ];

        return view('feedback.index', [
            'feedbackItems' => $feedbackItems,
            'stats' => $stats,
            'courses' => $courses,
            'filters' => $request->only(['course_id', 'date_from', 'date_to', 'search']),
        ]);
    }

    /**
     * Show form to create a new feedback entry.
     */
    public function create()
    {
        $courses = Course::orderBy('name')->get();

        return view('feedback.create', compact('courses'));
    }

    /**
     * Store a new feedback entry (admin).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'course_name' => ['required', 'string', 'max:255'],
            'venue_name' => ['nullable', 'string', 'max:255'],
            'course_date' => ['required', 'date'],
            'trainer_name' => ['required', 'string', 'max:255'],
        ]);

        $course = Course::firstOrCreate(['name' => $data['course_name']]);
        $venue = null;

        if (!empty($data['venue_name'])) {
            $venue = Venue::firstOrCreate(['name' => $data['venue_name']]);
        }

        Feedback::create([
            'course_id' => $course->id,
            'venue_id' => $venue?->id,
            'course_date' => $data['course_date'],
            'trainer_name' => $data['trainer_name'],
            'response_code' => '111',
            'has_learner_survey' => true,
            'is_scanned' => false,
        ]);

        return redirect()->route('feedback.index')->with('status', 'Feedback form created.');
    }

    /**
     * Show the learner questionnaire for a given feedback entry.
     */
    public function showSurvey(Feedback $feedback)
    {
        abort_unless($feedback->has_learner_survey, 404);

        if (session()->has("survey_completed.{$feedback->id}")) {
            return view('survey.already_submitted', compact('feedback'));
        }

        $questions = AboutYourTrainingQuestion::orderBy('display_order')->get();

        return view('survey.show', compact('feedback', 'questions'));
    }

    /**
     * Store learner questionnaire responses (both pages).
     */
    public function submitSurvey(Request $request, Feedback $feedback)
    {
        abort_unless($feedback->has_learner_survey, 404);

        $data = $request->validate($this->surveyValidationRules());
        $form = $this->saveSurveyResponses($feedback, $data);
        $questions = AboutYourTrainingQuestion::orderBy('display_order')->get();

        session()->put("survey_completed.{$feedback->id}", true);

        return view('survey.thanks', compact('feedback', 'form', 'questions'));
    }

    /**
     * Show the questionnaire form for admin to enter a response.
     */
    public function createResponse(Feedback $feedback)
    {
        abort_unless($feedback->has_learner_survey, 404);

        $questions = AboutYourTrainingQuestion::orderBy('display_order')->get();

        return view('survey.admin.show', compact('feedback', 'questions'));
    }


    /**
     * Store a response entered by an admin from the dashboard.
     */
    public function storeResponse(Request $request, Feedback $feedback)
    {
        abort_unless($feedback->has_learner_survey, 404);

        $data = $request->validate($this->surveyValidationRules());
        $this->saveSurveyResponses($feedback, $data);

        return redirect()
            ->route('feedback.responses', $feedback)
            ->with('status', 'Response recorded.');
    }

    /**
     * View submitted responses for a feedback entry.
     */
    public function responses(Feedback $feedback)
    {
        $forms = $feedback->learnerQuestionnaireForms()
            ->withCount('answers')
            ->with('demographics')
            ->latest()
            ->paginate(50);

        return view('feedback.responses', compact('feedback', 'forms'));
    }

    /**
     * View a single response in detail.
     */
    public function showResponse(Feedback $feedback, LearnerQuestionnaireForm $form)
    {
        abort_unless($form->feedback_id === $feedback->id, 404);

        $questions = AboutYourTrainingQuestion::orderBy('display_order')->get();
        $form->load(['answers', 'answers.question', 'demographics']);

        return view('feedback.response_show', compact('feedback', 'form', 'questions'));
    }

    /**
     * Show image import form for a feedback entry.
     */
    public function showImageImport(Feedback $feedback)
    {
        return view('import.image_upload', compact('feedback'));
    }

    /**
     * Handle image upload and parse it with OpenAI, then redirect to preview.
     */
    public function processImageImport(Request $request, Feedback $feedback, OpenAiSurveyParser $parser)
    {
        $data = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:20480'],
        ]);

        return back()
            ->withErrors([
                'image' => 'Image import via OpenAI is currently disabled. Please enter the response manually.',
            ])
            ->withInput();
    }

    /**
     * Show preview of data parsed from image before saving.
     */
    public function showImagePreview(Feedback $feedback)
    {
        $preview = session("import_preview.{$feedback->id}");

        if (!$preview) {
            return redirect()
                ->route('feedback.responses', $feedback)
                ->with('status', 'No import in progress for this feedback.');
        }

        $questions = AboutYourTrainingQuestion::orderBy('display_order')->get();

        return view('import.image_preview', [
            'feedback' => $feedback,
            'questions' => $questions,
            'preview' => $preview,
        ]);
    }

    /**
     * Confirm preview and create a response from parsed image data.
     */
    public function confirmImageImport(Request $request, Feedback $feedback)
    {
        $preview = session("import_preview.{$feedback->id}");

        if (!$preview) {
            return redirect()
                ->route('feedback.responses', $feedback)
                ->with('status', 'No import in progress for this feedback.');
        }

        $data = $preview['demographics'] ?? [];
        $data['answers'] = $preview['answers'] ?? [];

        $this->saveSurveyResponses($feedback, $data);

        session()->forget("import_preview.{$feedback->id}");

        return redirect()
            ->route('feedback.responses', $feedback)
            ->with('status', 'Response imported from image.');
    }

    /**
     * Delete a feedback entry and all related data after password confirmation.
     */
    public function destroy(Request $request, Feedback $feedback)
    {
        $request->validate([
            'password' => ['required'],
        ]);

        if (!Hash::check($request->input('password'), $request->user()->password)) {
            return back()
                ->withErrors([
                    'delete_password' => 'The password you entered is incorrect.',
                ])
                ->with('delete_feedback_url', route('feedback.destroy', $feedback))
                ->with('delete_feedback_title', optional($feedback->course)->name . ' – ' . $feedback->course_date->format('Y-m-d'));
        }

        $feedback->delete();

        return redirect()
            ->route('feedback.index')
            ->with('status', 'Feedback form and its responses were deleted.');
    }

    /**
     * Download a copy of a learner's response as HTML.
     */
    public function downloadResponse(LearnerQuestionnaireForm $form)
    {
        $form->load(['feedback.course', 'feedback.venue', 'answers.question', 'demographics']);

        $pdf = Pdf::loadView('survey.download', [
            'form' => $form,
        ]);

        $filename = 'learner-survey-response-' . $form->id . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export responses for a single feedback as CSV.
     */
    public function exportResponses(Feedback $feedback)
    {
        $questions = AboutYourTrainingQuestion::orderBy('display_order')->get();

        $forms = $feedback->learnerQuestionnaireForms()
            ->with(['answers', 'demographics', 'feedback.course', 'feedback.venue'])
            ->orderBy('created_at')
            ->get();

        $filename = 'feedback_' . $feedback->id . '_responses.csv';

        return response()->streamDownload(function () use ($feedback, $forms, $questions) {
            $handle = fopen('php://output', 'w');

            $headers = [
                'feedback_id',
                'course_name',
                'course_date',
                'trainer_name',
                'venue_name',
                'response_id',
                'submitted_at',
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

            foreach ($questions as $question) {
                $headers[] = $question->question_code;
            }

            fputcsv($handle, $headers);

            foreach ($forms as $form) {
                $demographics = $form->demographics;
                $answerLookup = $form->answers->keyBy('question_id');

                $row = [
                    $feedback->id,
                    optional($feedback->course)->name,
                    $feedback->course_date?->format('Y-m-d'),
                    $feedback->trainer_name,
                    optional($feedback->venue)->name,
                    $form->id,
                    $form->created_at?->format('Y-m-d H:i:s'),
                    optional($demographics)->best_aspects,
                    optional($demographics)->needs_improvement,
                    optional($demographics)->qualification_full_title,
                    optional($demographics)->qualification_level,
                    optional($demographics)->training_broad_field,
                    optional($demographics)->training_start_month,
                    optional($demographics)->training_start_year,
                    optional($demographics)->is_apprenticeship_or_traineeship,
                    optional($demographics)->has_recognition_of_prior_learning,
                    optional($demographics)->speaks_language_other_than_english_at_home,
                    optional($demographics)->is_permanent_resident_or_citizen,
                    optional($demographics)->has_disability_or_impairment,
                    optional($demographics)->sex_code,
                    optional($demographics)->age_band_code,
                    optional($demographics)->atsi_origin_code,
                    optional($demographics)->postcode,
                ];

                foreach ($questions as $question) {
                    $row[] = optional($answerLookup->get($question->id))->answer;
                }

                fputcsv($handle, $row);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Export all responses for all feedback as CSV.
     */
    public function exportAllResponses()
    {
        $questions = AboutYourTrainingQuestion::orderBy('display_order')->get();

        $forms = LearnerQuestionnaireForm::with([
            'feedback.course',
            'feedback.venue',
            'answers',
            'demographics',
        ])->orderBy('created_at')->get();

        $filename = 'all_feedback_responses.csv';

        return response()->streamDownload(function () use ($forms, $questions) {
            $handle = fopen('php://output', 'w');

            $headers = [
                'feedback_id',
                'course_name',
                'course_date',
                'trainer_name',
                'venue_name',
                'response_id',
                'submitted_at',
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

            foreach ($questions as $question) {
                $headers[] = $question->question_code;
            }

            fputcsv($handle, $headers);

            foreach ($forms as $form) {
                $feedback = $form->feedback;
                $demographics = $form->demographics;
                $answerLookup = $form->answers->keyBy('question_id');

                $row = [
                    optional($feedback)->id,
                    optional(optional($feedback)->course)->name,
                    optional($feedback?->course_date)->format('Y-m-d'),
                    optional($feedback)->trainer_name,
                    optional(optional($feedback)->venue)->name,
                    $form->id,
                    $form->created_at?->format('Y-m-d H:i:s'),
                    optional($demographics)->best_aspects,
                    optional($demographics)->needs_improvement,
                    optional($demographics)->qualification_full_title,
                    optional($demographics)->qualification_level,
                    optional($demographics)->training_broad_field,
                    optional($demographics)->training_start_month,
                    optional($demographics)->training_start_year,
                    optional($demographics)->is_apprenticeship_or_traineeship,
                    optional($demographics)->has_recognition_of_prior_learning,
                    optional($demographics)->speaks_language_other_than_english_at_home,
                    optional($demographics)->is_permanent_resident_or_citizen,
                    optional($demographics)->has_disability_or_impairment,
                    optional($demographics)->sex_code,
                    optional($demographics)->age_band_code,
                    optional($demographics)->atsi_origin_code,
                    optional($demographics)->postcode,
                ];

                foreach ($questions as $question) {
                    $row[] = optional($answerLookup->get($question->id))->answer;
                }

                fputcsv($handle, $row);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Validation rules for survey submissions.
     */
    private function surveyValidationRules(): array
    {
        return [
            'consent' => ['accepted'],
            'answers' => ['required', 'array'],
            'answers.*' => ['required', 'integer', 'min:1', 'max:4'],
            'best_aspects' => ['nullable', 'string'],
            'needs_improvement' => ['nullable', 'string'],
            'qualification_full_title' => ['nullable', 'string', 'max:255'],
            'qualification_level' => ['nullable', 'integer'],
            'training_broad_field' => ['nullable', 'integer'],
            'training_start_month_year' => ['nullable', 'date_format:Y-m'],
            'is_apprenticeship_or_traineeship' => ['nullable', 'boolean'],
            'has_recognition_of_prior_learning' => ['nullable', 'boolean'],
            'speaks_language_other_than_english_at_home' => ['nullable', 'boolean'],
            'is_permanent_resident_or_citizen' => ['nullable', 'boolean'],
            'has_disability_or_impairment' => ['nullable', 'boolean'],
            'sex_code' => ['nullable', 'integer'],
            'age_band_code' => ['nullable', 'integer'],
            'atsi_origin_code' => ['nullable', 'integer'],
            'postcode' => ['nullable', 'digits:4'],
        ];
    }

    /**
     * Persist survey responses and demographics.
     */
    private function saveSurveyResponses(Feedback $feedback, array $data): LearnerQuestionnaireForm
    {
        return DB::transaction(function () use ($feedback, $data) {
            $form = LearnerQuestionnaireForm::create([
                'feedback_id' => $feedback->id,
            ]);

            foreach ($data['answers'] as $questionId => $answerValue) {
                LearnerQuestionnaireAnswer::create([
                    'learner_questionnaire_form_id' => $form->id,
                    'question_id' => $questionId,
                    'answer' => $answerValue,
                ]);
            }

            $startMonth = null;
            $startYear = null;
            if (!empty($data['training_start_month_year'] ?? null)) {
                try {
                    $date = \Carbon\Carbon::createFromFormat('Y-m', $data['training_start_month_year']);
                    $startMonth = $date->month;
                    $startYear = $date->year;
                } catch (\Exception $e) {
                    // Ignore parse errors; leave month/year as null.
                }
            }

            LearnerQuestionnaireDemographic::create([
                'learner_questionnaire_form_id' => $form->id,
                'best_aspects' => $data['best_aspects'] ?? null,
                'needs_improvement' => $data['needs_improvement'] ?? null,
                'qualification_full_title' => $data['qualification_full_title'] ?? null,
                'qualification_level' => $data['qualification_level'] ?? null,
                'training_broad_field' => $data['training_broad_field'] ?? null,
                'training_start_month' => $startMonth,
                'training_start_year' => $startYear,
                'is_apprenticeship_or_traineeship' => $data['is_apprenticeship_or_traineeship'] ?? null,
                'has_recognition_of_prior_learning' => $data['has_recognition_of_prior_learning'] ?? null,
                'speaks_language_other_than_english_at_home' => $data['speaks_language_other_than_english_at_home'] ?? null,
                'is_permanent_resident_or_citizen' => $data['is_permanent_resident_or_citizen'] ?? null,
                'has_disability_or_impairment' => $data['has_disability_or_impairment'] ?? null,
                'sex_code' => $data['sex_code'] ?? null,
                'age_band_code' => $data['age_band_code'] ?? null,
                'atsi_origin_code' => $data['atsi_origin_code'] ?? null,
                'postcode' => $data['postcode'] ?? null,
            ]);

            return $form;
        });
    }

    /**
     * Convert answer codes (LQxx) to question ids.
     */
    private function mapAnswerCodesToQuestionIds(array $answersByCode): array
    {
        if (empty($answersByCode)) {
            return [];
        }

        $questions = AboutYourTrainingQuestion::pluck('id', 'question_code');
        $mapped = [];

        foreach ($answersByCode as $code => $value) {
            if (isset($questions[$code])) {
                $mapped[$questions[$code]] = $value;
            }
        }

        return $mapped;
    }
}
