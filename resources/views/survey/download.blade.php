<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $form->is_employer ? 'Employer Questionnaire Response' : 'Learner Questionnaire Response' }}</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-size: 14px;
            line-height: 1.5;
            margin: 24px;
            color: #222;
        }
        h1 {
            font-size: 20px;
            margin-bottom: 8px;
        }
        h2 {
            font-size: 16px;
            margin-top: 24px;
            margin-bottom: 6px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            vertical-align: top;
        }
        table th {
            background: #f0f0f0;
        }
    </style>
</head>
<body>
    <h1>
        {{ $form->is_employer ? 'Employer Questionnaire Response' : 'Learner Questionnaire Response' }}
    </h1>
    <p><strong>Course:</strong> {{ $form->feedback->course?->name }}</p>
    <p><strong>Date:</strong> {{ $form->feedback->course_date?->format('Y-m-d') }}</p>
    <p><strong>Trainer:</strong> {{ $form->feedback->trainer_name }}</p>
    @if ($form->feedback->venue)
        <p><strong>Venue:</strong> {{ $form->feedback->venue->name }}</p>
    @endif
    <p><strong>Submitted at:</strong> {{ $form->created_at?->format('Y-m-d H:i:s') }}</p>

    <h2>
        {{ $form->is_employer ? "About your employees' training" : 'About your training' }}
    </h2>
    <table>
        <thead>
        <tr>
            <th style="width: 65%;">Question</th>
            <th>Answer (1–4)</th>
            <th>Answer text</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($form->answers as $answer)
            @php
                $label = match($answer->answer) {
                    1 => 'Strongly disagree',
                    2 => 'Disagree',
                    3 => 'Agree',
                    4 => 'Strongly agree',
                    default => null,
                };
            @endphp
            <tr>
                <td>{{ $answer->question?->question }}</td>
                <td>{{ $answer->answer }}</td>
                <td>{{ $label }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>Open comments</h2>
    <p><strong>Best aspects of the training:</strong><br>{{ $form->demographics->best_aspects ?? '—' }}</p>
    <p><strong>Aspects needing improvement:</strong><br>{{ $form->demographics->needs_improvement ?? '—' }}</p>

    @unless ($form->is_employer)
        <h2>Training details and about you</h2>
        @php $d = $form->demographics; @endphp
        <p><strong>Qualification title:</strong> {{ $d->qualification_full_title ?? '—' }}</p>
        <p><strong>Qualification level code:</strong> {{ $d->qualification_level ?? '—' }}</p>
        <p><strong>Broad field code:</strong> {{ $d->training_broad_field ?? '—' }}</p>
        <p><strong>Start month/year:</strong> {{ $d->training_start_month ?? '—' }}/{{ $d->training_start_year ?? '—' }}</p>
        <p><strong>Apprenticeship/traineeship:</strong>
            @if (!is_null($d->is_apprenticeship_or_traineeship))
                {{ $d->is_apprenticeship_or_traineeship ? 'Yes' : 'No' }}
            @else
                —
            @endif
        </p>
        <p><strong>Recognition of prior learning:</strong>
            @if (!is_null($d->has_recognition_of_prior_learning))
                {{ $d->has_recognition_of_prior_learning ? 'Yes' : 'No' }}
            @else
                —
            @endif
        </p>
        <p><strong>Language other than English at home:</strong>
            @if (!is_null($d->speaks_language_other_than_english_at_home))
                {{ $d->speaks_language_other_than_english_at_home ? 'Yes' : 'No' }}
            @else
                —
            @endif
        </p>
        <p><strong>Permanent resident or citizen:</strong>
            @if (!is_null($d->is_permanent_resident_or_citizen))
                {{ $d->is_permanent_resident_or_citizen ? 'Yes' : 'No' }}
            @else
                —
            @endif
        </p>
        <p><strong>Disability/impairment:</strong>
            @if (!is_null($d->has_disability_or_impairment))
                {{ $d->has_disability_or_impairment ? 'Yes' : 'No' }}
            @else
                —
            @endif
        </p>
        <p><strong>Sex code:</strong> {{ $d->sex_code ?? '—' }}</p>
        <p><strong>Age band code:</strong> {{ $d->age_band_code ?? '—' }}</p>
        <p><strong>ATSI origin code:</strong> {{ $d->atsi_origin_code ?? '—' }}</p>
        <p><strong>Postcode:</strong> {{ $d->postcode ?? '—' }}</p>
    @endunless
</body>
</html>
