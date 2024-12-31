<div id="timer">
    Time Remaining: <span id="time">{{ $exam->duration * 60 }}</span> seconds
</div>

<script>
    let time = {{ $exam->duration * 60 }};
    const timer = document.getElementById('time');

    const countdown = setInterval(() => {
        time--;
        timer.textContent = time;

        if (time <= 0) {
            clearInterval(countdown);
            alert('Time is up! Submitting the exam.');
            document.querySelector('form').submit();
        }
    }, 1000);
</script>

<form action="{{ route('exam.submit', $exam) }}" method="POST">
    @csrf
    @foreach($questions as $question)
        <p>{{ $question->question_text }}</p>
        <label>
            <input type="radio" name="responses[{{ $question->id }}]" value="option_a"> {{ $question->option_a }}
        </label>
        <label>
            <input type="radio" name="responses[{{ $question->id }}]" value="option_b"> {{ $question->option_b }}
        </label>
        <label>
            <input type="radio" name="responses[{{ $question->id }}]" value="option_c"> {{ $question->option_c }}
        </label>
        <label>
            <input type="radio" name="responses[{{ $question->id }}]" value="option_d"> {{ $question->option_d }}
        </label>
    @endforeach
    <button type="submit">Submit</button>
</form>
