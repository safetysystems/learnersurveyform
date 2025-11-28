@extends('layouts.app')

@section('title', 'Feedback Forms')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h1 class="h4 mb-1">AQTF Form Feedbacks</h1>
            <p class="text-muted mb-0 small">
                Manage learner questionnaire links and responses for your courses.
            </p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('feedback.export.all') }}" class="btn btn-outline-secondary">
                Export all (CSV)
            </a>
            <a href="{{ route('feedback.create') }}" class="btn btn-primary">
                + Create AQTF Questionnaire form
            </a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form
                id="feedback-filters-form"
                method="GET"
                action="{{ route('feedback.index') }}"
                class="row g-3 align-items-end"
            >
                <div class="col-md-3">
                    <label for="filter-course" class="form-label">Course</label>
                    <select
                        id="filter-course"
                        name="course_id"
                        class="form-select"
                    >
                        <option value="">All courses</option>
                        @foreach ($courses as $course)
                            <option
                                value="{{ $course->id }}"
                                @selected(($filters['course_id'] ?? '') == $course->id)
                            >
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="filter-date-from" class="form-label">From date</label>
                    <input
                        type="date"
                        id="filter-date-from"
                        name="date_from"
                        class="form-control"
                        value="{{ $filters['date_from'] ?? '' }}"
                    >
                </div>

                <div class="col-md-2">
                    <label for="filter-date-to" class="form-label">To date</label>
                    <input
                        type="date"
                        id="filter-date-to"
                        name="date_to"
                        class="form-control"
                        value="{{ $filters['date_to'] ?? '' }}"
                    >
                </div>

                <div class="col-md-3">
                    <label for="filter-search" class="form-label">Search</label>
                    <input
                        type="text"
                        id="filter-search"
                        name="search"
                        class="form-control"
                        value="{{ $filters['search'] ?? '' }}"
                        placeholder="Trainer, course or venue"
                    >
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        Apply filters
                    </button>
                    <a href="{{ route('feedback.index') }}" class="btn btn-light-secondary flex-fill">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="basic-key-table" class="table table-hover align-middle mb-0">
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
                    @foreach ($feedbackItems as $feedback)
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
                                    @php($link = route('survey.show', $feedback))
                                    <div class="d-flex flex-column gap-1">
                                        <div class="d-flex flex-wrap gap-2">
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-secondary copy-link-btn"
                                                data-link="{{ $link }}"
                                            >
                                                <i class="ti ti-link me-1"></i> Copy link
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-secondary show-qr-btn"
                                                data-link="{{ $link }}"
                                                data-label="Feedback #{{ $feedback->id }}"
                                            >
                                                <i class="ti ti-qrcode me-1"></i> Generate QR
                                            </button>
                                        </div>
                                        <span class="small text-muted">
                                            Share link or QR with learners.
                                        </span>
                                    </div>
                                @else
                                    <span class="badge bg-secondary">Disabled</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <span class="badge rounded-pill bg-primary px-3">
                                    {{ $feedback->learner_questionnaire_forms_count }}
                                </span>
                            </td>

                            <td class="text-end">
                                <div class="btn-group" role="group" aria-label="Feedback actions">
                                    <a
                                        href="{{ route('feedback.responses', $feedback) }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        View
                                    </a>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-danger delete-feedback-btn"
                                        data-delete-url="{{ route('feedback.destroy', $feedback) }}"
                                        data-feedback-title="{{ optional($feedback->course)->name }} – {{ $feedback->course_date->format('Y-m-d') }}"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteFeedbackModal" tabindex="-1" aria-labelledby="deleteFeedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteFeedbackModalLabel">Delete feedback form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="deleteFeedbackForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p class="mb-2">
                            This will permanently delete the feedback form and all learner responses for:
                        </p>
                        <p class="fw-semibold mb-3" data-role="feedback-title"></p>
                        <p class="mb-3 small text-muted">
                            This action cannot be undone. To confirm, please enter your password.
                        </p>
                        <div class="mb-0">
                            <label for="delete-feedback-password" class="form-label">Password</label>
                            <input
                                type="password"
                                class="form-control"
                                id="delete-feedback-password"
                                name="password"
                                required
                            >
                            @error('delete_password')
                                <div class="small text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('feedback-filters-form');
            if (!form) {
                return;
            }

            const autoChangeInputs = form.querySelectorAll('select, input[type="date"]');
            autoChangeInputs.forEach(function (el) {
                el.addEventListener('change', function () {
                    form.submit();
                });
            });

            const searchInput = form.querySelector('input[name="search"]');
            if (searchInput) {
                let timeoutId = null;
                searchInput.addEventListener('input', function () {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(function () {
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

            document.body.addEventListener('click', function (event) {
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
            (function () {
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
