@extends('layouts.app')

@section('title', 'Feedback Forms')

@push('styles')
    <style>
        .feedback-page .feedback-table thead th {
            font-size: 0.75rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom-color: #e5e7eb;
        }

        .feedback-page .feedback-table tbody tr {
            border-bottom: 1px solid #f1f3f5;
        }

        .feedback-page .feedback-table tbody tr:last-child {
            border-bottom-color: transparent;
        }

        .feedback-page .feedback-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .feedback-page .survey-actions-group .small {
            font-weight: 500;
            letter-spacing: 0.04em;
        }

        .feedback-page .survey-actions-group .input-group-sm>.form-control {
            font-size: 0.75rem;
            background-color: #f8fafc;
        }

        .feedback-page .survey-actions-group .input-group-sm>.form-control:focus {
            box-shadow: none;
        }

        .feedback-page .survey-actions-group .btn {
            font-size: 0.75rem;
            border-radius: 6px;
        }

        .feedback-page .responses-badge {
            background-color: var(--brand-orange);
            color: #fff;
            font-weight: 600;
        }

        .feedback-page .feedback-actions .btn {
            font-weight: 500;
            border-radius: 6px;
            padding-inline: 1.1rem;
        }

        .feedback-page .feedback-action-icon {
            width: 2.25rem;
            height: 2.25rem;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 767.98px) {
            .feedback-page .survey-actions {
                gap: 0.75rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="col-12 feedback-page">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
                <h1 class="h4 mb-1">AQTF Form Feedbacks</h1>
                <p class="text-muted mb-0 small">
                    Manage learner questionnaire links and responses for your courses.
                </p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-outline-secondary"
                    href="{{ route('feedback.export.all') }}">
                    Export all (CSV)
                </a>
                <a class="btn btn-primary"
                    href="{{ route('feedback.create') }}">
                    + Create AQTF Questionnaire form
                </a>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h5>Filters</h5>
                <br>
                <form action="{{ route('feedback.index') }}"
                    class="row g-3 align-items-end"
                    id="feedback-filters-form"
                    method="GET">
                    <div class="col-md-3">
                        <label class="form-label"
                            for="filter-course">Course</label>
                        <select class="form-select"
                            id="filter-course"
                            name="course_id">
                            <option value="">All courses</option>
                            @foreach ($courses as $course)
                                <option @selected(($filters['course_id'] ?? '') == $course->id)
                                    value="{{ $course->id }}">
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label"
                            for="filter-date-from">From date</label>
                        <input class="form-control"
                            id="filter-date-from"
                            name="date_from"
                            type="date"
                            value="{{ $filters['date_from'] ?? '' }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label"
                            for="filter-date-to">To date</label>
                        <input class="form-control"
                            id="filter-date-to"
                            name="date_to"
                            type="date"
                            value="{{ $filters['date_to'] ?? '' }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label"
                            for="filter-search">Search</label>
                        <input class="form-control"
                            id="filter-search"
                            name="search"
                            placeholder="Trainer, course or venue"
                            type="text"
                            value="{{ $filters['search'] ?? '' }}">
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button class="btn btn-primary flex-fill"
                            type="submit">
                            Apply filters
                        </button>
                        <a class="btn btn-light-secondary flex-fill"
                            href="{{ route('feedback.index') }}">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0 feedback-table"
                        id="basic-key-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course</th>
                                <th>Venue</th>
                                <th>Date</th>
                                <th>Trainer</th>
                                <th>Survey Link</th>
                                <th>Responses</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($feedbackItems as $feedback)
                                <tr>
                                    <td>#{{ $feedback->id }}</td>

                                    <td>
                                        {{ $feedback->course?->name ?? '—' }}
                                    </td>

                                    <td>
                                        {{ $feedback->venue?->name ?? '—' }}
                                    </td>

                                    <td>
                                        {{ $feedback->course_date->format('Y-m-d') }}
                                    </td>

                                    <td>
                                        {{ $feedback->trainer_name }}
                                    </td>

                                    <td>
                                        @if ($feedback->has_learner_survey)
                                            @php($learnerLink = route('survey.show', $feedback))
                                            @php($employerLink = route('employer.survey.show', $feedback))
                                            <div class="survey-actions d-flex flex-column gap-3">
                                                <div class="survey-actions-group flex-fill">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <div class="small text-dark">Learner survey</div>
                                                        <button class="btn btn-sm btn-light-primary show-qr-btn"
                                                            data-label="Learner survey – {{ $feedback->course?->name }} ({{ $feedback->course_date->format('Y-m-d') }})"
                                                            data-link="{{ $learnerLink }}"
                                                            type="button">
                                                            <i class="ti ti-qrcode me-1"></i>Generate QR
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
                                                <hr>
                                                <div class="survey-actions-group flex-fill">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <div class="small text-dark">Employer survey</div>
                                                        <button class="btn btn-sm btn-light-primary show-qr-btn"
                                                            data-label="Employer survey – {{ $feedback->course?->name }} ({{ $feedback->course_date->format('Y-m-d') }})"
                                                            data-link="{{ $employerLink }}"
                                                            type="button">
                                                            <i class="ti ti-qrcode me-1"></i>Generate QR
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
                                        @else
                                            <span class="badge bg-secondary">Disabled</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <span class="badge rounded-pill bg-primary px-3 responses-badge">
                                            {{ $feedback->learner_questionnaire_forms_count }}
                                        </span>
                                    </td>

                                    <td class="text-end">
                                        <div
                                            class="feedback-actions d-flex flex-column flex-sm-row justify-content-end gap-2">
                                            <a class="btn btn-sm btn-primary feedback-action-icon"
                                                href="{{ route('feedback.responses', $feedback) }}">
                                                <i class="ti ti-eye"></i>
                                                <span class="visually-hidden">View responses</span>
                                            </a>
                                            <button
                                                class="btn btn-sm btn-light-danger feedback-action-icon delete-feedback-btn"
                                                data-delete-url="{{ route('feedback.destroy', $feedback) }}"
                                                data-feedback-title="{{ optional($feedback->course)->name }} – {{ $feedback->course_date->format('Y-m-d') }}"
                                                type="button">
                                                <i class="ti ti-trash"></i>
                                                <span class="visually-hidden">Delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted small"
                                        colspan="8">
                                        No feedback forms match your filters yet. Try adjusting the filters above or create
                                        a new form.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div aria-hidden="true"
            aria-labelledby="deleteFeedbackModalLabel"
            class="modal fade"
            id="deleteFeedbackModal"
            tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="deleteFeedbackModalLabel">Delete feedback form</h5>
                        <button aria-label="Close"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            type="button"></button>
                    </div>
                    <form id="deleteFeedbackForm"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <p class="mb-2">
                                This will permanently delete the feedback form and all learner responses for:
                            </p>
                            <p class="fw-semibold mb-3"
                                data-role="feedback-title"></p>
                            <p class="mb-3 small text-muted">
                                This action cannot be undone. To confirm, please enter your password.
                            </p>
                            <div class="mb-0">
                                <label class="form-label"
                                    for="delete-feedback-password">Password</label>
                                <input class="form-control"
                                    id="delete-feedback-password"
                                    name="password"
                                    required
                                    type="password">
                                @error('delete_password')
                                    <div class="small text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light-secondary"
                                data-bs-dismiss="modal"
                                type="button">Cancel</button>
                            <button class="btn btn-danger"
                                type="submit">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('feedback-filters-form');
            if (!form) {
                return;
            }

            const autoChangeInputs = form.querySelectorAll('select, input[type="date"]');
            autoChangeInputs.forEach(function(el) {
                el.addEventListener('change', function() {
                    form.submit();
                });
            });

            const searchInput = form.querySelector('input[name="search"]');
            if (searchInput) {
                let timeoutId = null;
                searchInput.addEventListener('input', function() {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(function() {
                        form.submit();
                    }, 500);
                });
            }

            const deleteModalEl = document.getElementById('deleteFeedbackModal');
            const deleteForm = document.getElementById('deleteFeedbackForm');
            const passwordInput = document.getElementById('delete-feedback-password');
            const titleTarget = deleteModalEl ? deleteModalEl.querySelector('[data-role="feedback-title"]') : null;
            let deleteModal = null;

            if (deleteModalEl && typeof bootstrap !== 'undefined') {
                deleteModal = new bootstrap.Modal(deleteModalEl);
            }

            document.body.addEventListener('click', function(event) {
                const btn = event.target.closest('.delete-feedback-btn');
                if (!btn || !deleteModal || !deleteForm) {
                    return;
                }

                const url = btn.getAttribute('data-delete-url');
                const title = btn.getAttribute('data-feedback-title') || '';
                if (!url) {
                    return;
                }

                deleteForm.setAttribute('action', url);
                if (titleTarget) {
                    titleTarget.textContent = title;
                }
                if (passwordInput) {
                    passwordInput.value = '';
                }

                deleteModal.show();
            });

            @if ($errors->has('delete_password') && session('delete_feedback_url'))
                (function() {
                    if (!deleteModalEl || !deleteForm || typeof bootstrap === 'undefined') {
                        return;
                    }

                    deleteForm.setAttribute('action', @json(session('delete_feedback_url')));
                    if (titleTarget) {
                        titleTarget.textContent = @json(session('delete_feedback_title'));
                    }
                    if (passwordInput) {
                        passwordInput.value = '';
                    }

                    const modalInstance = new bootstrap.Modal(deleteModalEl);
                    modalInstance.show();
                    if (passwordInput) {
                        passwordInput.focus();
                    }
                })();
            @endif
        });
    </script>
@endpush
