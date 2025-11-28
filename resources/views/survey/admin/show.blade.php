
@extends('layouts.app')

@section('title', 'Add survey response')

@section('content')
<div class="container my-4">
    <h1 class="h3 mb-3 text-uppercase text-center">Learner Questionnaire</h1>

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

    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="small text-muted">Course</div>
                    <div class="fw-semibold">
                        {{ optional($feedback->course)->name ?? '—' }}
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="small text-muted">Date</div>
                    <div class="fw-semibold">
                        {{ $feedback->course_date?->format('Y-m-d') ?? '—' }}
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="small text-muted">Trainer</div>
                    <div class="fw-semibold">
                        {{ $feedback->trainer_name ?? '—' }}
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="small text-muted">Venue</div>
                    <div class="fw-semibold">
                        {{ optional($feedback->venue)->name ?? '—' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3 p-3 border bg-white">
        <p class="mb-2 fw-bold">Important instructions</p>
        <p class="small mb-2">
            Please tell us about your training. Your feedback plays an important role in developing the quality of your
            education. In this questionnaire, the term <em>training</em> refers to learning experiences with your
            training organisation.
        </p>
        <p class="small mb-0">
            For each statement below, please tick one box only. Use the following scale:
            <strong>1 = Strongly disagree</strong>, <strong>2 = Disagree</strong>,
            <strong>3 = Agree</strong>, <strong>4 = Strongly agree</strong>.
        </p>
    </div>

    <form method="post" action="{{ route('feedback.responses.store', $feedback) }}">
        @csrf

        <div class="card mb-4">
            <div class="card-header">
                <strong>About this questionnaire</strong>
            </div>
            <div class="card-body">
                <p class="mb-2">
                    This questionnaire is based on the Australian Quality Training Framework (AQTF) Learner
                    Questionnaire. Your answers help your training organisation and government agencies understand the
                    quality of training you received.
                </p>
                <ul class="small">
                    <li>Your responses are combined with other learners' responses and reported in summary form.</li>
                    <li>Information may be used to monitor training quality, meet regulatory reporting requirements and
                        improve courses and support services.</li>
                    <li>Your individual answers are not used to assess your competency or results in this course.</li>
                    <li>Do not include names or information that directly identifies other people.</li>
                </ul>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" value="1" id="consent"
                           name="consent" {{ old('consent') ? 'checked' : '' }} required>
                    <label class="form-check-label" for="consent">
                        I have read and understood the information above and I agree to provide feedback about my
                        training.
                    </label>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-orange-500 text-white">
                <strong>About your training</strong>
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
                                        @php($id = 'q'.$question->id.'_'.$i)
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
                                    @php($id = 'm_q'.$question->id.'_'.$i)
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

        <div class="card mb-4">
            <div class="card-header">
                <strong>Your training details</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">What type of qualification are you currently enrolled in?</label>
                    <select name="qualification_level" class="form-select">
                        <option value="">Please select</option>
                        <option value="1">Certificate I</option>
                        <option value="2">Certificate II</option>
                        <option value="3">Certificate III</option>
                        <option value="4">Certificate IV</option>
                        <option value="5">Certificate level unknown</option>
                        <option value="6">Diploma</option>
                        <option value="7">Advanced diploma</option>
                        <option value="8">Associate degree</option>
                        <option value="9">Degree</option>
                        <option value="10">Short course or statement of attainment</option>
                        <option value="11">VET graduate certificate or graduate diploma</option>
                        <option value="12">Other qualification or training</option>
                        <option value="13">Do not know</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">What is the broad field of your current training?</label>
                    <select name="training_broad_field" class="form-select">
                        <option value="">Please select</option>
                        <option value="1">Natural and physical sciences</option>
                        <option value="2">Information technology</option>
                        <option value="3">Engineering and related technologies</option>
                        <option value="4">Architecture and building</option>
                        <option value="5">Agriculture, environmental and related studies</option>
                        <option value="6">Health</option>
                        <option value="7">Education</option>
                        <option value="8">Management and commerce</option>
                        <option value="9">Society and culture</option>
                        <option value="10">Creative arts</option>
                        <option value="11">Food, hospitality and personal services</option>
                        <option value="12">Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">What is the full title of your current qualification or training?</label>
                    <input type="text" name="qualification_full_title" class="form-control"
                           value="{{ old('qualification_full_title') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">When did the learner start their current training?</label>
                    <input
                        type="month"
                        name="training_start_month_year"
                        class="form-control"
                        value="{{ old('training_start_month_year') }}"
                    >
                    <div class="form-text">
                        Select the month and year the learner started (for example, March 2007).
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <strong>About you</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label d-block">Are you undertaking an apprenticeship or traineeship?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_apprenticeship_or_traineeship"
                               value="1">
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_apprenticeship_or_traineeship"
                               value="0">
                        <label class="form-check-label">No</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Did you get any recognition of prior learning?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="has_recognition_of_prior_learning"
                               value="1">
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="has_recognition_of_prior_learning"
                               value="0">
                        <label class="form-check-label">No</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Are you female or male?</label>
                    <select name="sex_code" class="form-select">
                        <option value="">Please select</option>
                        <option value="1">Female</option>
                        <option value="2">Male</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">What is your age in years?</label>
                    <select name="age_band_code" class="form-select">
                        <option value="">Please select</option>
                        <option value="1">Under 15</option>
                        <option value="2">15 to 19</option>
                        <option value="3">20 to 24</option>
                        <option value="4">25 to 34</option>
                        <option value="5">35 to 44</option>
                        <option value="6">45 to 54</option>
                        <option value="7">55 to 64</option>
                        <option value="8">65 or over</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Are you of Aboriginal or Torres Strait Islander origin?</label>
                    <select name="atsi_origin_code" class="form-select">
                        <option value="">Please select</option>
                        <option value="1">No</option>
                        <option value="2">Yes, Aboriginal</option>
                        <option value="3">Yes, Torres Strait Islander</option>
                        <option value="4">Yes, both Aboriginal and Torres Strait Islander</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Do you speak a language other than English at home?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                               name="speaks_language_other_than_english_at_home" value="1">
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                               name="speaks_language_other_than_english_at_home" value="0">
                        <label class="form-check-label">No</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Are you a permanent resident or citizen of Australia?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                               name="is_permanent_resident_or_citizen" value="1">
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                               name="is_permanent_resident_or_citizen" value="0">
                        <label class="form-check-label">No</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Do you consider yourself to have a disability, impairment or
                        long-term condition?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                               name="has_disability_or_impairment" value="1">
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                               name="has_disability_or_impairment" value="0">
                        <label class="form-check-label">No</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">What is the postcode of your main place of residence?</label>
                    <input
                        type="text"
                        name="postcode"
                        class="form-control"
                        inputmode="numeric"
                        pattern="\d{4}"
                        maxlength="4"
                        value="{{ old('postcode') }}"
                    >
                    <div class="form-text">
                        Enter the learner's 4-digit postcode.
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <button type="submit" class="btn btn-primary">
                Submit response
            </button>
            <a href="{{ route('feedback.responses', $feedback) }}" class="btn btn-outline-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
