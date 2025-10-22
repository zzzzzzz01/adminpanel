<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'group_subject_id',
        'time_limit',
        'is_active',
        'start_date',
        'end_date',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'test_id', 'id');
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function groupSubject()
    {
        return $this->belongsTo(GroupSubject::class);
    }

    public function examSessions()
    {
        return $this->belongsToMany(ExamSession::class, 'exam_session_test', 'test_id', 'exam_session_id');
    }

    public function answers()
    {
        return $this->hasMany(ExamSessionAnswer::class, 'test_id');
    }

    // Test.php modelida
    public function getStudentResultAttribute()
    {
        $studentId = auth()->id();
        $totalQuestions = $this->questions()->count();
        $correctAnswers = $this->answers()
            ->where('student_id', $studentId)
            ->where('is_correct', true)
            ->count();
        
        $maxScore = $this->groupSubject->max_final_score ?? 50;
        $earnedScore = 0;
        
        if ($totalQuestions > 0) {
            $earnedScore = round(($correctAnswers / $totalQuestions) * $maxScore, 1);
        }
        
        return [
            'correct_answers' => $correctAnswers,
            'total_questions' => $totalQuestions,
            'earned_score' => $earnedScore,
            'max_score' => $maxScore
        ];
    }

}
