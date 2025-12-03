@extends('layouts.app')

@section('title', 'Survey Responses')

@push('styles')
    <style>
        .feedback-responses-page .survey-actions-group .small {
            font-weight: 500;
            letter-spacing: 0.04em;
        }

        .feedback-responses-page .survey-actions-group .input-group-sm>.form-control {
            font-size: 0.75rem;
            background-color: #f8fafc;
        }

        .feedback-responses-page .survey-actions-group .input-group-sm>.form-control:focus {
            box-shadow: none;
        }

        .feedback-responses-page .survey-actions-group .btn {
            font-size: 0.75rem;
            border-radius: 999px;
        }

        .feedback-responses-page .response-filter-group .response-filter-btn {
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 500;
            padding-inline: 1.1rem;
            border-color: #e5e7eb;
            color: #374151;
            background-color: #ffffff;
        }

        .feedback-responses-page .response-filter-group .response-filter-btn:not(.active):hover {
            background-color: #f9fafb;
        }

        .feedback-responses-page .response-filter-group .response-filter-btn.active {
            background-color: var(--brand-orange);
            border-color: var(--brand-orange);
            color: #ffffff;
        }

        @media (max-width: 767.98px) {
            .feedback-responses-page .survey-actions {
                gap: 0.75rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="col-12 feedback-responses-page">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-0">Survey Responses</h1>
            <div class="d-flex gap-2">
                <div class="btn-group btn-group-sm"
                    aria-label="Export responses"
                    role="group">
                    <a class="btn btn-outline-secondary"
                        href="{{ route('feedback.export', $feedback) }}">
                        Export all (CSV)
                    </a>
                    <a class="btn btn-outline-secondary"
                        href="{{ route('feedback.export', ['feedback' => $feedback, 'type' => 'learner']) }}">
                        Learners
                    </a>
                    <a class="btn btn-outline-secondary"
                        href="{{ route('feedback.export', ['feedback' => $feedback, 'type' => 'employer']) }}">
                        Employers
                    </a>
                </div>
                <a class="btn btn-primary btn-sm"
                    href="{{ route('feedback.responses.create', $feedback) }}">
                    + Add response
                </a>
            </div>
        </div>

        <div class="mb-3">
            <p class="mb-1"><strong>Course:</strong> {{ $feedback->course?->name }}</p>
            <p class="mb-1"><strong>Date:</strong> {{ $feedback->course_date->format('Y-m-d') }}</p>
            <p class="mb-1"><strong>Trainer:</strong> {{ $feedback->trainer_name }}</p>
            @if ($feedback->venue)
                <p class="mb-0"><strong>Venue:</strong> {{ $feedback->venue->name }}</p>
            @endif
        </div>

        @if ($feedback->has_learner_survey)
            @php($learnerLink = route('survey.show', $feedback))
            @php($employerLink = route('employer.survey.show', $feedback))
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="h6 text-uppercase text-muted mb-3">Survey links</h2>
                    <div class="survey-actions d-flex flex-column gap-3">
                        <div class="survey-actions-group flex-fill">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="small text-muted">Learner survey</div>
                                <button class="btn btn-sm btn-light-primary show-qr-btn"
                                    data-label="Learner survey – {{ $feedback->course?->name }} ({{ $feedback->course_date->format('Y-m-d') }})"
                                    data-link="{{ $learnerLink }}"
                                    type="button">
                                    <i class="ti ti-qrcode me-1"></i>Generate learner QR
                                </button>
                            </div>
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-sm text-truncate"
                                    readonly
                                    title="{{ $learnerLink }}"
                                    type="text"
                                    value="{{ $learnerLink }}">
                                <button class="btn btn-sm btn-outline-secondary copy-link-btn"
                                    data-link="{{ $learnerLink }}"
                                    type="button">
                                    Copy link
                                </button>
                            </div>
                        </div>
                        <div class="survey-actions-group flex-fill">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="small text-muted">Employer survey</div>
                                <button class="btn btn-sm btn-light-primary show-qr-btn"
                                    data-label="Employer survey – {{ $feedback->course?->name }} ({{ $feedback->course_date->format('Y-m-d') }})"
                                    data-link="{{ $employerLink }}"
                                    type="button">
                                    <i class="ti ti-qrcode me-1"></i>Generate employer QR
                                </button>
                            </div>
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-sm text-truncate"
                                    readonly
                                    title="{{ $employerLink }}"
                                    type="text"
                                    value="{{ $employerLink }}">
                                <button class="btn btn-sm btn-outline-secondary copy-link-btn"
                                    data-link="{{ $employerLink }}"
                                    type="button">
                                    Copy link
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center">
                <h2 class="h5 mb-0">Responses ({{ $forms->total() }})</h2>
                <div class="d-inline-flex gap-2 response-filter-group"
                    aria-label="Filter responses">
                    @php($current = $filter ?? null)
                    <a class="btn response-filter-btn {{ $current === null ? 'active' : '' }}"
                        href="{{ route('feedback.responses', $feedback) }}">
                        All
                    </a>
                    <a class="btn response-filter-btn {{ $current === 'learner' ? 'active' : '' }}"
                        href="{{ route('feedback.responses', ['feedback' => $feedback, 'type' => 'learner']) }}">
                        Learners
                    </a>
                    <a class="btn response-filter-btn {{ $current === 'employer' ? 'active' : '' }}"
                        href="{{ route('feedback.responses', ['feedback' => $feedback, 'type' => 'employer']) }}">
                        Employers
                    </a>
                </div>
            </div>
            @if ($forms->total() > 0)
                <span class="small text-muted">Showing {{ $forms->firstItem() }}–{{ $forms->lastItem() }}</span>
            @endif
        </div>

        @if ($forms->isEmpty())
            <p class="text-muted">No responses for this filter yet.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Submitted at</th>
                            <th>Type</th>
                            <th>Answers count</th>
                            <th>Best aspects (snippet)</th>
                            <th>Needs improvement (snippet)</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($forms as $form)
                            <tr>
                                <td>{{ $form->id }}</td>
                                <td>{{ $form->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <span
                                        class="badge rounded-pill {{ $form->is_employer ? 'bg-secondary' : 'bg-success' }}">
                                        {{ $form->is_employer ? 'Employer' : 'Learner' }}
                                    </span>
                                </td>
                                <td>{{ $form->answers_count }}</td>
                                <td class="text-truncate"
                                    style="max-width: 250px;">
                                    {{ \Illuminate\Support\Str::limit($form->demographics->best_aspects ?? '', 60) }}
                                </td>
                                <td class="text-truncate"
                                    style="max-width: 250px;">
                                    {{ \Illuminate\Support\Str::limit($form->demographics->needs_improvement ?? '', 60) }}
                                </td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-outline-secondary"
                                        href="{{ route('feedback.responses.show', [$feedback, $form]) }}">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $forms->links() }}
        @endif
    </div>
@endsection
