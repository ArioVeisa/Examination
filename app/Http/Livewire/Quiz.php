<?php

namespace App\Http\Livewire;

use App\Models\Exam;
use App\Models\User;
use App\Models\Audio;
use App\Models\Image;
use App\Models\Video;
use Livewire\Component;
use App\Models\Document;
use App\Models\Question;
use Livewire\WithPagination;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Builder;

class Quiz extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $exam_id;
    public $user_id;
    public $selectedAnswers = [];
    public $total_question;
    protected $listeners = ['endTimer' => 'submitAnswers'];

    public function mount($id)
    {
        $this->exam_id = $id;
        
    }

    public function updatedPage()
    {
        $this->emit("pageChanged");
    }

    public function questions()
    {
        $exam = Exam::findOrFail($this->exam_id);
        $exam_questions = $exam->questions;
        $this->total_question = $exam_questions->count();

        if($this->total_question >= $exam->total_question) {
            $questions = $exam->questions()->take($exam->total_question)->paginate(1);
        } elseif($this->total_question < $exam->total_question ) {
            $questions = $exam->questions()->take($this->total_question)->paginate(1);
        } 
        return $questions;
    }

    public function answers($questionId, $option)
    {
        $this->selectedAnswers[$questionId] = $questionId.'-'.$option;
    }

    public function submitAnswers()
    {
        if(!empty($this->selectedAnswers))
        {
            
            $score = 0;
            foreach($this->selectedAnswers as $key => $value)
            {
                $userAnswer = "";
                $rightAnswer = Question::findOrFail($key)->answer;
                $userAnswer = substr($value, strpos($value,'-')+1);
                $bobot = 1;
                if($userAnswer == $rightAnswer){
                    $score = $score + $bobot;
                }
                
                

            }
        }else{
            $score = 0;
        }

    // kalkulator

        if ($score == 0) {
            $score = 210;
        } elseif ($score == 1) {
            $score = 220;
        }elseif ($score == 2) {
            $score = 230;
        }elseif ($score == 3) {
            $score = 230;
        }elseif ($score == 4) {
            $score = 240;
        }
        elseif ($score == 5) {
            $score = 250;
        }elseif ($score == 6) {
            $score = 260;
        }
        elseif ($score == 7) {
            $score = 270;
        }elseif ($score == 8) {
            $score = 280;
        }elseif ($score == 9) {
            $score = 280;
        }
        elseif ($score == 10) {
            $score = 290;
        }elseif ($score == 11) {
            $score = 300;
        }
        elseif ($score == 12) {
            $score = 210;
        }elseif ($score == 13) {
            $score = 320;
        }
        elseif ($score == 14) {
            $score = 340;
        }elseif ($score == 15) {
            $score = 350;
        }
        elseif ($score == 16) {
            $score = 360;
        }elseif ($score == 17) {
            $score = 370;
        }
        elseif ($score == 18) {
            $score = 380;
        }elseif ($score == 19) {
            $score = 390;
        }
        elseif ($score == 20) {
            $score = 400;
        }elseif ($score == 21) {
            $score = 410;
        }
        elseif ($score == 22) {
            $score = 420;
        }elseif ($score == 23) {
            $score = 430;
        }
        elseif ($score == 24) {
            $score = 430;
        }elseif ($score == 25) {
            $score = 440;
        }
        elseif ($score == 26) {
            $score = 450;
        }elseif ($score == 27) {
            $score = 460;
        }
        elseif ($score == 28) {
            $score = 460;
        }elseif ($score == 29) {
            $score = 470;
        }
        elseif ($score == 30) {
            $score = 480;
        }elseif ($score == 31) {
            $score = 480;
        }
        elseif ($score == 32) {
            $score = 490;
        }elseif ($score == 33) {
            $score = 500;
        }
        elseif ($score == 34) {
            $score = 510;
        }elseif ($score == 35) {
            $score = 520;
        }
        elseif ($score == 36) {
            $score = 520;
        }elseif ($score == 37) {
            $score = 530;
        }
        elseif ($score == 38) {
            $score = 540;
        }elseif ($score == 39) {
            $score = 540;
        }
        elseif ($score == 40) {
            $score = 550;
        }elseif ($score == 41) {
            $score = 560;
        }
        elseif ($score == 42) {
            $score = 570;
        }elseif ($score == 43) {
            $score = 480;
        }
        elseif ($score == 44) {
            $score = 590;
        }elseif ($score == 45) {
            $score = 600;
        }
        elseif ($score == 46) {
            $score = 610;
        }elseif ($score == 47) {
            $score = 630;
        }
        elseif ($score == 48) {
            $score = 650;
        }elseif ($score == 49) {
            $score = 660;
        }elseif ($score == 50) {
            $score = 670;
        };
        
        $selectedAnswers_str = json_encode($this->selectedAnswers);
        $this->user_id = Auth()->id();
        $user = User::findOrFail($this->user_id);
        $user_exam = $user->whereHas('exams', function (Builder $query) {
            $query->where('exam_id',$this->exam_id)->where('user_id',$this->user_id);
        })->count();
        if($user_exam == 0)
        {
            $user->exams()->attach($this->exam_id, ['history_answer' => $selectedAnswers_str, 'score' => $score]);
        } else{
            $user->exams()->updateExistingPivot($this->exam_id, ['history_answer' => $selectedAnswers_str, 'score' => $score]);
        }
        
        return redirect()->route('exams.result', [$score, $this->user_id, $this->exam_id]);
    }

    public function render()
    {
        return view('livewire.quiz', [
            'exam'      => Exam::findOrFail($this->exam_id),
            'questions' => $this->questions(),
            'video'     => new Video(),
            'audio'     => new Audio(),
            'document'  => new Document(),
            'image'     => new Image()
        ]);
    }
}