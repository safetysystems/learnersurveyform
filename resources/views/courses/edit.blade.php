@extends('layouts.app')

@section('title', 'Edit course')

@section('content')
    <h1 class="h3 mb-4">Edit course</h1>

    <form method="post" action="{{ route('courses.update', $course) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Course name</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name', $course->name) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Save changes</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection

