@extends('layouts.app')

@section('title', 'Response details')

@section('content')
    <h1 class="h3 mb-3">Response details</h1>

    <div class="mb-3">
        <p class="mb-1"><strong>Course:</strong> {{ $feedback->course?->name }}</p>
        <p class="mb-1"><strong>Date:</strong> {{ $feedback->course_date->format('Y-m-d') }}</p>
        <p class="mb-1"><strong>Trainer:</strong> {{ $feedback->trainer_name }}</p>
        @if ($feedback->venue)
            <p class="mb-0"><strong>Venue:</strong> {{ $feedback->venue->name }}</p>
        @endif
    </div>

    <div class="mb-3">
        <a href="{{ route('feedback.responses', $feedback) }}" class="btn btn-sm btn-outline-secondary">
            Back to responses
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <span>Response #{{ $form->id }}</span>
                <span class="small text-muted">
                    Submitted {{ $form->created_at->format('Y-m-d H:i') }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <h3 class="h6">About your training</h3>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>Question</th>
                        <th class="text-end">Answer (1–4)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($questions as $question)
                        @php
                            $answer = $form->answers->firstWhere('question_id', $question->id);
                        @endphp
                        <tr>
                            <td>{{ $question->question }}</td>
                            <td class="text-end">
                                {{ $answer?->answer ?? '—' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            @if ($form->demographics)
                <hr>
                <h3 class="h6">Open comments</h3>
                <p><strong>Best aspects:</strong><br>{{ $form->demographics->best_aspects ?: '—' }}</p>
                <p><strong>Needs improvement:</strong><br>{{ $form->demographics->needs_improvement ?: '—' }}</p>

                <h3 class="h6">Training details</h3>
                <p class="mb-1"><strong>Qualification title:</strong> {{ $form->demographics->qualification_full_title ?: '—' }}</p>
                <p class="mb-1"><strong>Qualification level code:</strong> {{ $form->demographics->qualification_level ?? '—' }}</p>
                <p class="mb-1"><strong>Broad field code:</strong> {{ $form->demographics->training_broad_field ?? '—' }}</p>
                <p class="mb-1">
                    <strong>Start:</strong>
                    {{ $form->demographics->training_start_month ?? '—' }}/{{ $form->demographics->training_start_year ?? '—' }}
                </p>

                <h3 class="h6 mt-3">About the learner (codes)</h3>
                <p class="mb-1"><strong>Sex code:</strong> {{ $form->demographics->sex_code ?? '—' }}</p>
                <p class="mb-1"><strong>Age band code:</strong> {{ $form->demographics->age_band_code ?? '—' }}</p>
                <p class="mb-1"><strong>ATSI origin code:</strong> {{ $form->demographics->atsi_origin_code ?? '—' }}</p>
                <p class="mb-1"><strong>Postcode:</strong> {{ $form->demographics->postcode ?? '—' }}</p>
            @endif
        </div>
    </div>
@endsection
