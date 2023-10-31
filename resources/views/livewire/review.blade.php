<div class="card w-100">
    <div class="card-header">
        <div class="row">
            <h4><i class="fas fa-exam"></i> {{ $exam['name'] }} </h4>
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
    
    
    <div class="d-flex justify-content-center">
        {{$questions->links()}}
    </div>
    <div class="card-footer">
        @if ($questions->currentPage() == $questions->lastPage())
        <a href="{{ route('exams.index') }}" class="btn btn-primary btn-lg btn-block" role="button" aria-pressed="true">BACK</a>
        @endif
    </div>
</div>


