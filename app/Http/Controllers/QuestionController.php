<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function status(Question $question)
    {

        // dd($question->id);

        // Holatni avtomatik teskari qilish
        $question->is_active = $question->is_active ? 0 : 1;
        $question->save();

        return back()->with('success', 'Savol holati o‘zgartirildi.');
    }
}
