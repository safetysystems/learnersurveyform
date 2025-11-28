@extends('layouts.app')

@section('title', 'Add question')

@section('content')
    <h1 class="h3 mb-4">Add question</h1>

    <form method="post" action="{{ route('questions.store') }}">
        @csrf

        <div class="mb-3">
            <label for="question" class="form-label">Question text</label>
            <textarea name="question" id="question" rows="3" class="form-control" required>{{ old('question') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="question_code" class="form-label">Code (optional)</label>
            <input type="text" name="question_code" id="question_code" class="form-control"
                   value="{{ old('question_code') }}" placeholder="e.g. LQ37">
            <div class="form-text">
                If left blank, a new code like <code>LQ37</code> will be generated.
            </div>
        </div>

        <div class="mb-3">
            <label for="display_order" class="form-label">Display order (optional)</label>
            <input type="number" name="display_order" id="display_order" class="form-control"
                   value="{{ old('display_order') }}">
            <div class="form-text">
                Leave blank to place the question at the end of the list.
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('questions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection

