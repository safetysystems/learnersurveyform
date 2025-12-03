<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employer Questionnaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
            font-size: 16px;
            line-height: 1.6;
        }

        .question-table th,
        .question-table td {
            vertical-align: middle;
        }

        .bg-orange-500 {
            background-color: #ff7206;
        }

        @media (max-width: 576px) {
            .question-table th,
            .question-table td {
                font-size: 0.8rem;
                padding: 0.35rem 0.4rem;
            }

            .question-table th:first-child,
            .question-table td:first-child {
                min-width: 220px;
            }
        }
    </style>
</head>
<body>
<div class="container my-4">
    <h1 class="h3 mb-3 text-uppercase text-center">Employer Questionnaire</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <p class="mb-1 fw-bold">Please check the form:</p>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3 p-3 border bg-white">
        <p class="mb-2 fw-bold">Important instructions</p>
        <p class="small mb-2">
            Please tell us about the training your employee received from this training organisation. Your feedback
            helps improve the quality of training and support services.
        </p>
        <p class="small mb-0">
            For each statement below, please tick one box only. Use the following scale:
            <strong>1 = Strongly disagree</strong>, <strong>2 = Disagree</strong>,
            <strong>3 = Agree</strong>, <strong>4 = Strongly agree</strong>.
        </p>
    </div>

    <form method="post" action="{{ route('employer.survey.submit', $feedback) }}">
        @csrf

        <div class="card mb-4">
            <div class="card-header">
                <strong>About this questionnaire</strong>
            </div>
            <div class="card-body">
                <p class="mb-2">
                    This questionnaire is based on the Australian Quality Training Framework (AQTF) Employer
                    Questionnaire. Your answers help the training organisation and government agencies understand how
                    well the training meets employers' needs.
                </p>
                <ul class="small">
                    <li>Your responses are combined with other employers' responses and reported in summary form.</li>
                    <li>Information may be used to monitor training quality, meet regulatory reporting requirements and
                        improve courses and support services.</li>
                    <li>Your individual answers are not identified to your employees.</li>
                    <li>Do not include names or information that directly identifies individual employees.</li>
                </ul>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" value="1" id="consent"
                           name="consent" {{ old('consent') ? 'checked' : '' }} required>
                    <label class="form-check-label" for="consent">
                        I have read and understood the information above and I agree to provide feedback about our
                        employees' training.
                    </label>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-orange-500 text-white">
                <strong>About your employees' training</strong>
            </div>
            <div class="card-body p-0">
                {{-- Desktop / tablet: table layout --}}
                <div class="d-none d-md-block">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 align-middle question-table">
                            <thead class="table-light">
                            <tr>
                                <th class="w-50">Please mark one box for each statement</th>
                                <th class="text-center">
                                    <div class="small">Strongly disagree</div>
                                    <div class="small text-muted">1</div>
                                </th>
                                <th class="text-center">
                                    <div class="small">Disagree</div>
                                    <div class="small text-muted">2</div>
                                </th>
                                <th class="text-center">
                                    <div class="small">Agree</div>
                                    <div class="small text-muted">3</div>
                                </th>
                                <th class="text-center">
                                    <div class="small">Strongly agree</div>
                                    <div class="small text-muted">4</div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($questions as $question)
                                <tr>
                                    <td>{{ $question->question }}</td>
                                    @for ($i = 1; $i <= 4; $i++)
                                        @php($id = 'eq'.$question->id.'_'.$i)
                                        <td class="text-center">
                                            <div class="form-check d-inline-block">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       id="{{ $id }}"
                                                       name="answers[{{ $question->id }}]"
                                                       value="{{ $i }}">
                                                <label class="visually-hidden" for="{{ $id }}">
                                                    {{ $question->question }} — option {{ $i }}
                                                </label>
                                            </div>
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Mobile: stacked layout, no horizontal scroll --}}
                <div class="d-md-none p-3">
                    @foreach ($questions as $question)
                        <div class="mb-3 p-3 border rounded bg-white">
                            <p class="mb-2">{{ $question->question }}</p>
                            <div class="d-grid gap-1">
                                @for ($i = 1; $i <= 4; $i++)
                                    @php($id = 'm_eq'.$question->id.'_'.$i)
                                    <label class="form-check mb-1">
                                        <input class="form-check-input me-2"
                                               type="radio"
                                               id="{{ $id }}"
                                               name="answers[{{ $question->id }}]"
                                               value="{{ $i }}">
                                        <span class="form-check-label">
                                            @if ($i === 1)
                                                Strongly disagree (1)
                                            @elseif ($i === 2)
                                                Disagree (2)
                                            @elseif ($i === 3)
                                                Agree (3)
                                            @else
                                                Strongly agree (4)
                                            @endif
                                        </span>
                                    </label>
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <strong>What were the BEST aspects of the training?</strong>
            </div>
            <div class="card-body">
                <textarea name="best_aspects" rows="3" class="form-control">{{ old('best_aspects') }}</textarea>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <strong>What aspects of the training were MOST in need of improvement?</strong>
            </div>
            <div class="card-body">
                <textarea name="needs_improvement" rows="3" class="form-control">{{ old('needs_improvement') }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
