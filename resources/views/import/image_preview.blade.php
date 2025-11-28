@extends('layouts.app')

@section('title', 'Import preview')

@section('content')
    <h1 class="h3 mb-3">Import preview</h1>

    <div class="mb-3">
        <p class="mb-1"><strong>Course:</strong> {{ $feedback->course?->name }}</p>
        <p class="mb-1"><strong>Date:</strong> {{ $feedback->course_date->format('Y-m-d') }}</p>
        <p class="mb-1"><strong>Trainer:</strong> {{ $feedback->trainer_name }}</p>
        @if ($feedback->venue)
            <p class="mb-0"><strong>Venue:</strong> {{ $feedback->venue->name }}</p>
        @endif
    </div>

    <p class="small text-muted">
        This is how the uploaded image has been interpreted. Review carefully. If anything looks wrong, press
        "Cancel" and enter the response manually.
    </p>

    <div class="card mb-4">
        <div class="card-header">
            <strong>About your training – answers</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                    <tr>
                        <th>Question</th>
                        <th class="text-end">Answer (1–4)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($questions as $question)
                        @php
                            $value = $preview['answers'][$question->id] ?? null;
                        @endphp
                        <tr>
                            <td>{{ $question->question }}</td>
                            <td class="text-end">
                                {{ $value ?? '—' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Open comments</strong>
        </div>
        <div class="card-body">
            <p><strong>Best aspects:</strong><br>{{ $preview['demographics']['best_aspects'] ?? '—' }}</p>
            <p><strong>Needs improvement:</strong><br>{{ $preview['demographics']['needs_improvement'] ?? '—' }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Training details and about you</strong>
        </div>
        <div class="card-body small">
            @php $d = $preview['demographics'] ?? []; @endphp
            <p class="mb-1"><strong>Qualification title:</strong> {{ $d['qualification_full_title'] ?? '—' }}</p>
            <p class="mb-1"><strong>Qualification level code:</strong> {{ $d['qualification_level'] ?? '—' }}</p>
            <p class="mb-1"><strong>Broad field code:</strong> {{ $d['training_broad_field'] ?? '—' }}</p>
            <p class="mb-1">
                <strong>Start month/year:</strong>
                {{ $d['training_start_month'] ?? '—' }}/{{ $d['training_start_year'] ?? '—' }}
            </p>
            <p class="mb-1"><strong>Apprenticeship/traineeship:</strong>
                @if (array_key_exists('is_apprenticeship_or_traineeship', $d))
                    {{ $d['is_apprenticeship_or_traineeship'] ? 'Yes' : 'No' }}
                @else
                    —
                @endif
            </p>
            <p class="mb-1"><strong>Recognition of prior learning:</strong>
                @if (array_key_exists('has_recognition_of_prior_learning', $d))
                    {{ $d['has_recognition_of_prior_learning'] ? 'Yes' : 'No' }}
                @else
                    —
                @endif
            </p>
            <p class="mb-1"><strong>Language other than English at home:</strong>
                @if (array_key_exists('speaks_language_other_than_english_at_home', $d))
                    {{ $d['speaks_language_other_than_english_at_home'] ? 'Yes' : 'No' }}
                @else
                    —
                @endif
            </p>
            <p class="mb-1"><strong>Permanent resident or citizen:</strong>
                @if (array_key_exists('is_permanent_resident_or_citizen', $d))
                    {{ $d['is_permanent_resident_or_citizen'] ? 'Yes' : 'No' }}
                @else
                    —
                @endif
            </p>
            <p class="mb-1"><strong>Disability/impairment:</strong>
                @if (array_key_exists('has_disability_or_impairment', $d))
                    {{ $d['has_disability_or_impairment'] ? 'Yes' : 'No' }}
                @else
                    —
                @endif
            </p>
            <p class="mb-1"><strong>Sex code:</strong> {{ $d['sex_code'] ?? '—' }}</p>
            <p class="mb-1"><strong>Age band code:</strong> {{ $d['age_band_code'] ?? '—' }}</p>
            <p class="mb-1"><strong>ATSI origin code:</strong> {{ $d['atsi_origin_code'] ?? '—' }}</p>
            <p class="mb-1"><strong>Postcode:</strong> {{ $d['postcode'] ?? '—' }}</p>
        </div>
    </div>

    <form method="post" action="{{ route('feedback.import.confirm', $feedback) }}">
        @csrf
        <button type="submit" class="btn btn-primary">Confirm and save response</button>
        <a href="{{ route('feedback.responses', $feedback) }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection

