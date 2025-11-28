@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Courses</h1>
        <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm">
            + Add course
        </a>
    </div>

    <p class="small text-muted">
        Manage the list of standard courses. When creating a feedback form you can select from these courses, or enter
        a one-off special course name.
    </p>

    @if ($courses->isEmpty())
        <p>No courses defined yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th>Name</th>
                    <th class="text-center">Feedback forms</th>
                    <th class="text-end"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $course->name }}</td>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $course->feedback_count }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-outline-secondary">
                                Edit
                            </a>
                            <form action="{{ route('courses.destroy', $course) }}" method="post" class="d-inline"
                                  onsubmit="return confirm('Delete this course? Existing feedback will keep its course name, but this will remove it from the list.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{ $courses->links() }}
    @endif
@endsection
