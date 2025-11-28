<?php

namespace App\Http\Controllers;

use App\Models\AboutYourTrainingQuestion;
use Illuminate\Http\Request;

class AboutYourTrainingQuestionController extends Controller
{
    /**
     * Display a listing of the questions.
     */
    public function index()
    {
        $questions = AboutYourTrainingQuestion::orderBy('display_order')->get();

        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new question.
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created question in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'question_code' => ['nullable', 'string', 'max:50'],
            'question' => ['required', 'string'],
            'display_order' => ['nullable', 'integer'],
        ]);

        if (empty($data['question_code'])) {
            $nextNumber = (AboutYourTrainingQuestion::max('id') ?? 0) + 1;
            $data['question_code'] = 'LQ' . $nextNumber;
        }

        if (!isset($data['display_order'])) {
            $data['display_order'] = (AboutYourTrainingQuestion::max('display_order') ?? 0) + 1;
        }

        AboutYourTrainingQuestion::create($data);

        return redirect()->route('questions.index')->with('status', 'Question created.');
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit(AboutYourTrainingQuestion $question)
    {
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified question in storage.
     */
    public function update(Request $request, AboutYourTrainingQuestion $question)
    {
        $data = $request->validate([
            'question_code' => ['required', 'string', 'max:50'],
            'question' => ['required', 'string'],
            'display_order' => ['nullable', 'integer'],
        ]);

        $question->update($data);

        return redirect()->route('questions.index')->with('status', 'Question updated.');
    }

    /**
     * Remove the specified question from storage.
     */
    public function destroy(AboutYourTrainingQuestion $question)
    {
        $question->delete();

        return redirect()->route('questions.index')->with('status', 'Question deleted.');
    }
}

