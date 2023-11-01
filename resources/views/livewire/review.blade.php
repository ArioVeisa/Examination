<div class="card w-100">
    <div class="card-header">
        <div class="row">
            <h4><i class="fas fa-exam"></i> {{ $exam['name'] }} </h4>
        </div>
    </div>
    @foreach ($questions as $question)
    <div class="card-body overflow-hidden">
        <b>Soal No. {{ $questions->currentPage() }}</b>
        <p>{{ $question['detail'] }}</p>
        <div class="box-satu" style="overflow-x: auto">
            @if ($question['video_id'])
                <video width="320" height="240" controls>
                    <source src="{{ Storage::url('public/videos/'.$video->getLink($question['video_id'])) }}" type="video/mp4">
                    <source src="{{ Storage::url('public/videos/'.$video->getLink($question['video_id'])) }}" type="video/mpeg">
                </video>
            @elseif($question['audio_id'])
                <audio width="100px" height="12px" controls src="{{ Storage::url('public/audios/'.$audio->getLink($question['audio_id'])) }}" type="audio/mp3">
                    {{-- <source src="{{ Storage::url('public/audios/'.$audio->getLink($question['audio_id'])) }}" type="audio/mp3">
                    <source src="{{ Storage::url('public/audios/'.$audio->getLink($question['audio_id'])) }}" type="audio/wav"> --}}
                </audio>
            @elseif($question['document_id'])
                <a href=" {{ Storage::url('public/documents/'.$document->getLink($question['document_id'])) }}">DOCUMENT</a>
            @elseif($question['image_id'])
            <img src="{{ Storage::url('public/images/'.$image->getLink($question['image_id'])) }}" class="w-100">
            @else
                NO
            @endif
        </div>
        <br>
        <i>Pilih salah satu jawaban dibawah ini:</i> 
        <br>
        <div class="btn-group-vertical" role="group" aria-label="Basic example w-100 ">
            <div>
                <button type="button" class="mb-1 text-break {{ in_array($question['id'].'-'.$question['option_A'], $selectedAnswers) ? 'btn btn-success border border-secondary rounded' : 'btn btn-light border border-secondary rounded' }}"
                wire:click="answers({{ $question['id'] }}, '{{ $question['option_A'] }}')" style="white-space:pre-wrap"><p class="text-left"><b> A. {{ $question['option_A'] }} </b></p></button>
            </div>
            <div class="w-full">
                <button type="button" class="mb-1 {{ in_array($question['id'].'-'.$question['option_B'], $selectedAnswers) ? 'btn btn-success border border-secondary rounded' : 'btn btn-light border border-secondary rounded' }}"
                wire:click="answers({{ $question['id'] }}, '{{ $question['option_B'] }}')" style="white-space:pre-wrap"><p class="text-left"><b> B. {{ $question['option_B'] }} </b></p></button>
            </div>
            <div>
                <button type="button" class="mb-1 {{ in_array($question['id'].'-'.$question['option_C'], $selectedAnswers) ? 'btn btn-success border border-secondary rounded' : 'btn btn-light border border-secondary rounded' }}"
                wire:click="answers({{ $question['id'] }}, '{{ $question['option_C'] }}')" style="white-space:pre-wrap"><p class="text-left"><b> C. {{ $question['option_C'] }} </b></p></button>
            </div>
            <div>
                <button type="button" class="mb-1 {{ in_array($question['id'].'-'.$question['option_D'], $selectedAnswers) ? 'btn btn-success border border-secondary rounded' : 'btn btn-light border border-secondary rounded' }}"
                wire:click="answers({{ $question['id'] }}, '{{ $question['option_D'] }}')" style="white-space:pre-wrap"><p class="text-left"><b> D. {{ $question['option_D'] }} </b></p></button>
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


