<div class="card w-100">
    <div class="card-header">
        <div class="row">
            <div class="col-12">
                <h4><i class="fas fa-exam"></i> {{ $exam['name'] }} </h4>
            </div>
            <div class="col-12">
                <!-- Display the countdown timer in an element -->
                <span class="bg-danger p-1 text-white rounded" id="timer"></span>
            </div>
        </div>
    </div>
    @foreach ($questions as $question)
    <div class="card-body w-100">
        <b>Soal No. {{ $questions->currentPage() }}</b>
        <p>{{ $question['detail'] }}</p>
        <div class="box-satu w-100">
            @if ($question['video_id'])
                <video width="320" height="240" controls src="{{ Storage::url('public/videos/'.$video->getLink($question['video_id'])) }}" type="video/mp4">
                    {{-- <source src="{{ Storage::url('public/videos/'.$video->getLink($question['video_id'])) }}" type="video/mpeg"> --}}
                </video>
            @elseif($question['audio_id'])
            <div>
                <audio controls src="{{ Storage::url('public/audios/'.$audio->getLink($question['audio_id'])) }}" type="audio/mp3">
                    
                    {{-- <source src="{{ Storage::url('public/audios/'.$audio->getLink($question['audio_id'])) }}" type="audio/wav"> --}}
                </audio>
            </div>
            @elseif($question['document_id'])
                <a href=" {{ Storage::url('public/documents/'.$document->getLink($question['document_id'])) }}">DOCUMENT</a>
            @elseif($question['image_id'])
            <img src="{{ Storage::url('public/images/'.$image->getLink($question['image_id'])) }}" class="w-50">
            @else
                NO
            @endif
        </div>
        <br>
        <i>Pilih salah satu jawaban dibawah ini:</i> 
        <br>
        <div class="btn-group-vertical"  style="display: flex; flex-wrap: wrap; width: 100%;" role="group" aria-label="Basic example w-100 ">
            <div>
                <button type="button" class="mb-1 text-break {{ in_array($question['id'].'-'.$question['option_A'], $selectedAnswers) ? 'btn-success border border-secondary rounded' : 'btn-light border border-secondary rounded' }}"
                wire:click="answers({{ $question['id'] }}, '{{ $question['option_A'] }}')"><p class="text-left"><b> A. {{ $question['option_A'] }} </b></p></button>
            </div>
            <div>
                <button type="button" class="mb-1 {{ in_array($question['id'].'-'.$question['option_B'], $selectedAnswers) ? 'btn-success border border-secondary rounded' : ' btn-light border border-secondary rounded' }}"
                wire:click="answers({{ $question['id'] }}, '{{ $question['option_B'] }}')"><p class="text-left"><b> B. {{ $question['option_B'] }} </b></p></button>
            </div>
            <div>
                <button type="button" class="mb-1 {{ in_array($question['id'].'-'.$question['option_C'], $selectedAnswers) ? 'btn-success border border-secondary rounded' : 'btn-light border border-secondary rounded' }}"
                wire:click="answers({{ $question['id'] }}, '{{ $question['option_C'] }}')"><p class="text-left"><b> C. {{ $question['option_C'] }} </b></p></button>
            </div>
            <div>
                <button type="button" class="mb-1 {{ in_array($question['id'].'-'.$question['option_D'], $selectedAnswers) ? 'btn-success border border-secondary rounded' : 'btn-light border border-secondary rounded' }}"
                wire:click="answers({{ $question['id'] }}, '{{ $question['option_D'] }}')"><p class="text-left"><b> D. {{ $question['option_D'] }} </b></p></button>
            </div>
            
        </div>
        
    </div>
    @endforeach

    {{-- @foreach ($selectedAnswers as $item)
        {{ $item }}
    @endforeach --}}
    
    <div class="d-flex justify-content-center">
        {{$questions->links()}}
    </div>
    <div class="card-footer">
        @if ($questions->currentPage() == $questions->lastPage())
            <button wire:click="submitAnswers" class="btn btn-primary btn-lg btn-block">Submit</button>
        @endif
    </div>
</div>

<script>
    var add_minutes =  function (dt, minutes) {
    return new Date(dt.getTime() + minutes*60000);
    }
    
    // Get today's date and time
    var now = new Date();

    // Set the date we're counting down to
    var countDownDate = add_minutes(now, {{ $exam->time }});

    // Update the count down every 1 second
    var x = setInterval(function() {

    // Get today's date and time
    var now2 = new Date().getTime();

    // Find the distance between now and the count down date
    var distance = countDownDate - now2;

    // Time calculations for days, hours, minutes and seconds
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    document.getElementById("timer").innerHTML = "Sisa Waktu : " + hours + " jam "
    + minutes + " menit "+ seconds + " detik ";

    // If the count down is finished, write some text
    if (distance < 0) {
        clearInterval(x);
        Livewire.emit('endTimer');
    }
    }, 1000);
</script>
