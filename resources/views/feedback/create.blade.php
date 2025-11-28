@extends('layouts.app')

@section('title', 'Create Feedback')

@section('content')
    <h1 class="h3 mb-4">Create Feedback</h1>

    <form method="post" action="{{ route('feedback.store') }}">
        @csrf

        <div class="mb-3">
            <label for="course_name" class="form-label">Course</label>
            <input list="course_options"
                   name="course_name"
                   id="course_name"
                   class="form-control"
                   value="{{ old('course_name') }}"
                   required>
            <datalist id="course_options">
                @isset($courses)
                    @foreach ($courses as $course)
                        <option value="{{ $course->name }}"></option>
                    @endforeach
                @endisset
            </datalist>
            <div class="form-text">
                Start typing to select an existing course from the list, or enter a new course name.
            </div>
        </div>

        <div class="mb-3">
            <label for="venue_name" class="form-label">Venue name</label>
            <input type="text" name="venue_name" id="venue_name" class="form-control"
                   value="{{ old('venue_name') }}">
        </div>

        <div class="mb-3">
            <label for="course_date" class="form-label">Course date</label>
            <input type="date" name="course_date" id="course_date" class="form-control"
                   value="{{ old('course_date') }}" required>
        </div>

        <div class="mb-3">
            <label for="trainer_name" class="form-label">Trainer name</label>
            <input type="text" name="trainer_name" id="trainer_name" class="form-control"
                   value="{{ old('trainer_name') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('feedback.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
