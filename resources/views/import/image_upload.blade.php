@extends('layouts.app')

@section('title', 'Import from image')

@section('content')
    <h1 class="h3 mb-3">Import response from image</h1>

    <div class="mb-3">
        <p class="mb-1"><strong>Course:</strong> {{ $feedback->course?->name }}</p>
        <p class="mb-1"><strong>Date:</strong> {{ $feedback->course_date->format('Y-m-d') }}</p>
        <p class="mb-1"><strong>Trainer:</strong> {{ $feedback->trainer_name }}</p>
        @if ($feedback->venue)
            <p class="mb-0"><strong>Venue:</strong> {{ $feedback->venue->name }}</p>
        @endif
    </div>

    <p class="small text-muted">
        Upload a clear image (JPG or PNG) of a completed learner questionnaire. The system will attempt to read the
        responses. You will see a preview before anything is saved.
    </p>

    <form method="post" action="{{ route('feedback.import.image.process', $feedback) }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="image" class="form-label">Survey image</label>
            <input type="file" name="image" id="image" accept=".jpg,.jpeg,.png" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Upload and analyse</button>
        <a href="{{ route('feedback.responses', $feedback) }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection

