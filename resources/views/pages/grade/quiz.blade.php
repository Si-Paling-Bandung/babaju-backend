@extends('layouts.admin')

@section('title', 'List Detail Grades : ' . $user->name . '||' . $topic->title)

@section('main-content')

    <nav class="navbar navbar-light px-0 py-3">
        <h1 class="h3 mb-4 text-gray-800">{{ __('List Detail Grades : ') }}{{ $user->name }} || {{ $topic->title }} ||
            {{ $section === 'pre_test' ? 'Pre Test' : 'Post Test' }}
        </h1>
    </nav>

    <!-- <div class="container-fluid"> -->
    <!-- Content here -->
    <!-- <div class="row justify-content-center">
                            <div class="col-lg-10"> -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">List Detail Grades</h6>
        </div>
        <form method="POST" action="{{ route('detail.grade.show.quiz', [$id_user, $id_topic, $section]) }}"
            autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <!-- END OF TABLE -->
                <div class="">
                    <?php $i = 1;
                    $right = 0;
                    $wrong = 0; ?>
                    @foreach ($question as $qa)
                        <div>
                            <p>{{ $i++ }}.</p>
                            <p>{!! htmlspecialchars_decode(htmlspecialchars($qa->question)) !!}</p>
                            @if ($qa->user_answer === $qa->key)
                                <p class="text-success">User Answer <b>Right</b></p>
                                <?php $right++; ?>
                            @else
                                <p class="text-danger">User Answer <b>Wrong</b></p>
                                <?php $wrong++; ?>
                            @endif

                            <input type="radio" id="answer_1" name="{{ 'quiz' . $qa->id }}" value="answer_1" required
                                {{ $qa->user_answer == 'answer_1' ? 'checked' : '' }}>
                            <label for="answer_1">{{ $qa->answer_1 }}</label><br>

                            <input type="radio" id="answer_2" name="{{ 'quiz' . $qa->id }}" value="answer_2" required
                                {{ $qa->user_answer == 'answer_2' ? 'checked' : '' }}>
                            <label for="answer_2">{{ $qa->answer_2 }}</label><br>

                            <input type="radio" id="answer_3" name="{{ 'quiz' . $qa->id }}" value="answer_3" required
                                {{ $qa->user_answer == 'answer_3' ? 'checked' : '' }}>
                            <label for="answer_3">{{ $qa->answer_3 }}</label><br>

                            <input type="radio" id="answer_4" name="{{ 'quiz' . $qa->id }}" value="answer_4" required
                                {{ $qa->user_answer == 'answer_4' ? 'checked' : '' }}>
                            <label for="answer_4">{{ $qa->answer_4 }}</label><br>
                            <p>Key Answer : <b>{{ $qa->key }}</b></p>
                        </div>
                        <hr>
                    @endforeach
                    <p class="text-center"><b>Summary</b></p>
                    <p>Last Grade : <b>{{ $grade ? $grade->grade : 0 }}</b> / 100</p>
                    <p>Right Answer : <b>{{ $right }}</b></p>
                    <p>Wrong Answer : <b>{{ $wrong }}</b></p>
                </div>
                <!-- Button -->
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col text-center">
                            <a href="{{ url()->previous() }}" class="btn btn-dark">Back</a>
                            <button type="submit" class="btn btn-primary">{{ __('Edit') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
