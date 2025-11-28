@extends('layouts.app')

@section('title', 'Edit question')

@section('content')
    <h1 class="h3 mb-4">Edit question</h1>

    <form method="post" action="{{ route('questions.update', $question) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="question" class="form-label">Question text</label>
            <textarea name="question" id="question" rows="3" class="form-control" required>{{ old('question', $question->question) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="question_code" class="form-label">Code</label>
            <input type="text" name="question_code" id="question_code" class="form-control"
                   value="{{ old('question_code', $question->question_code) }}" required>
        </div>

        <div class="mb-3">
            <label for="display_order" class="form-label">Display order</label>
            <input type="number" name="display_order" id="display_order" class="form-control"
                   value="{{ old('display_order', $question->display_order) }}">
        </div>

        <button type="submit" class="btn btn-primary">Save changes</button>
        <a href="{{ route('questions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection

