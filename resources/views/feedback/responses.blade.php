@extends('layouts.app')

@section('title', 'Survey Responses')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Survey Responses</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('feedback.export', $feedback) }}" class="btn btn-outline-secondary btn-sm">
                Export responses (CSV)
            </a>
            {{-- <a href="{{ route('feedback.import.image', $feedback) }}" class="btn btn-outline-secondary btn-sm">
                Import from image
            </a> --}}
            <a href="{{ route('feedback.responses.create', $feedback) }}" class="btn btn-primary btn-sm">
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

    @if ($forms->isEmpty())
        <p>No responses have been submitted yet.</p>
    @else
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0">Responses ({{ $forms->total() }})</h2>
            <span class="small text-muted">Showing {{ $forms->firstItem() }}–{{ $forms->lastItem() }}</span>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Submitted at</th>
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
                        <td>{{ $form->answers_count }}</td>
                        <td class="text-truncate" style="max-width: 250px;">
                            {{ \Illuminate\Support\Str::limit($form->demographics->best_aspects ?? '', 60) }}
                        </td>
                        <td class="text-truncate" style="max-width: 250px;">
                            {{ \Illuminate\Support\Str::limit($form->demographics->needs_improvement ?? '', 60) }}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('feedback.responses.show', [$feedback, $form]) }}"
                               class="btn btn-sm btn-outline-secondary">
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
@endsection
