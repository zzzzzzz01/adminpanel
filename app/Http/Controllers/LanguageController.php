<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function language($lang)
    {
        // Faqat ruxsat berilgan tillarni qabul qilish
        if (in_array($lang, ['uz', 'en', 'ru'])) {
            session(['lang' => $lang]);   // sessioni lang dgan ozgaruvchisiga kelayotkan qiymatni eslab qoldik
            app()->setLocale($lang); // Laravel lokalizatsiyasini o'zgartirish
        }
        return back();
    }
}