@extends('layouts.app')

@section('title', 'Questions')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">About your training – questions</h1>
        <a href="{{ route('questions.create') }}" class="btn btn-primary btn-sm">Add question</a>
    </div>

    <p class="small text-muted">
        These questions appear on page 1 of the learner questionnaire. Changes here apply to all future surveys.
    </p>

    @if ($questions->isEmpty())
        <p>No questions have been defined yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th style="width: 80px;">Order</th>
                    <th style="width: 120px;">Code</th>
                    <th>Question</th>
                    <th style="width: 140px;"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($questions as $question)
                    <tr>
                        <td>{{ $question->display_order }}</td>
                        <td>{{ $question->question_code }}</td>
                        <td>{{ $question->question }}</td>
                        <td class="text-end">
                            <a href="{{ route('questions.edit', $question) }}" class="btn btn-sm btn-outline-secondary">
                                Edit
                            </a>
                            <form action="{{ route('questions.destroy', $question) }}" method="post" class="d-inline"
                                  onsubmit="return confirm('Delete this question? This will not remove existing responses.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
