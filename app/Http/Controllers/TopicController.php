<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Topic;
use App\Models\GroupSubject;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TopicController extends Controller
{
    public function index(GroupSubject $groupSubject)
    {
        $topics = $groupSubject->topics()->with('user')->get();
        return view('groups.groupSubject.topics.index', compact('groupSubject', 'topics'));
    }

    public function create(GroupSubject $groupSubject)
    {
        return view('groups.groupSubject.topics.create', compact('groupSubject'));
    }

    public function store(Request $request, GroupSubject $groupSubject)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|max:2048',
        ]);

        // dd($request);

        if($request->hasFile('file')){
            $name = $request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs('topics', $name, 'public');
        }

        // $filePath = null;
        // if ($request->hasFile('file')) {
        //     $filePath = $request->file('file')->store('topics', 'public');
        // }

        Topic::create([
            'group_subject_id' => $groupSubject->id,
            'title' => $request->title,
            'file_path' => $path ?? null,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('topics.index', $groupSubject)->with('success', 'Mavzu qo‘shildi!');
    }

    public function edit(Topic $topic)
    {
        $groupSubject = $topic->groupSubject;
        $topics = $groupSubject->topics()->with('user')->get(); // ✅ faqat shu groupSubjectga tegishli mavzular
        return view('groups.groupSubject.topics.index', compact('topic', 'topics', 'groupSubject'));
    }

    // Mavzuni yangilash
    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file'  => 'nullable|file|max:2048',
        ]);

        // Faylni yangilash
        if ($request->hasFile('file')) {
            // eski faylni o‘chirish
            if ($topic->file_path && Storage::exists($topic->file_path)) {
                Storage::delete($topic->file_path);
            }

            $filePath = $request->file('file')->store('topics');
            $topic->file_path = $filePath;
        }

        $topic->title = $request->title;
        $topic->save();

        return redirect()->route('topics.index', $topic->group_subject_id)
            ->with('success', 'Mavzu yangilandi!');
    }

    // Mavzuni o‘chirish
    public function destroy(Topic $topic)
    {
        // Faylni ham o‘chirish
        if ($topic->file_path && Storage::exists($topic->file_path)) {
            Storage::delete($topic->file_path);
        }

        $topic->delete();

        return redirect()->route('topics.index', $topic->group_subject_id)
            ->with('success', 'Mavzu o‘chirildi!');
    }

    public function showStudentTopics(GroupSubject $groupSubject)
    {
        // faqat shu groupSubjectga tegishli mavzularni olish
        $topics = $groupSubject->topics()->with('user')->get();

        return view('students.topics.index', compact('groupSubject', 'topics'));
    }

    public function teacherIndex()
    {
        $teacherId = auth()->id();
        $today = Carbon::today(); // bugungi sana
    
        // Aktiv semestrni aniqlaymiz
        $activeSemester = Semester::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->first();
    
        // Agar aktiv semestr topilmasa, bo‘sh qiymat qaytariladi
        if (!$activeSemester) {
            $groupSubjects = collect(); // bo‘sh kolleksiya
            return view('teachers.topics.index', compact('groupSubjects', 'teacherId', 'activeSemester'));
        }
    
        // Faqat ustozga tegishli va hozirgi semestrga oid fanlar
        $groupSubjects = GroupSubject::with(['group', 'subject', 'topics', 'semester'])
            ->where('teacher_id', $teacherId)
            ->where('semester_id', $activeSemester->id)
            ->get();
    
        return view('teachers.topics.index', compact('groupSubjects', 'teacherId', 'activeSemester'));
    }

    public function allTopics()
    {
        $teacherId = auth()->id();

        // Faqat ustozga tegishli group_subjectlar
        $groupSubjects = GroupSubject::with(['group', 'subject', 'topics'])
            ->where('teacher_id', $teacherId)
            ->get();

        return view('teachers.topics.all-topics', compact('groupSubjects', 'teacherId'));
    }

    public function showAllTopicsByGroupSubject($groupSubjectId)
    {
        $groupSubject = GroupSubject::with('topics')->findOrFail($groupSubjectId);

        return view('teachers.topics.all-topics-show', compact('groupSubject'));
    }
    
    public function teacherTopicCreate(GroupSubject $groupSubject)
    {
        $today = Carbon::today();
    
        // Fan semestri
        $semester = $groupSubject->semester;
    
        // Agar semestr tugagan bo‘lsa — ruxsat bermaymiz
        if ($semester && $semester->end_date < $today) {
            return redirect()->back()
                ->with('error', 'Bu fan uchun semestr muddati tugagan. Yangi mavzu qo‘shish mumkin emas.');
        }
    
        return view('teachers.topics.create', compact('groupSubject'));
    }

    public function teacherTopicStore(Request $request, GroupSubject $groupSubject)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|max:10240', // 10MB
        ]);
    
        $fileName = null;
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            // Faylni saqlash
            $file->storeAs('topics', $fileName, 'public');
        }
    
        Topic::create([
            'group_subject_id' => $groupSubject->id,
            'title' => $request->title,
            'file_path' => $fileName, // faqat fayl nomi saqlanadi
            'user_id' => Auth::id(),
        ]);
    
        return redirect()->route('topics.showByGroupSubject', $groupSubject)
            ->with('success', 'Mavzu qo‘shildi!');
    }

    // Mavzu qidirish
    public function topicsSearch(GroupSubject $groupSubject, Request $request)
    {
        $search = $request->input('search');

        // Agar qidiruv bo‘sh bo‘lsa, asosiy sahifaga qaytadi
        if (empty($search)) {
            return redirect()->route('topics.showByGroupSubject', $groupSubject->id);
        }

        $topics = $groupSubject->topics()
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        // Highlight qismi
        foreach ($topics as $t) {
            $t->title = preg_replace(
                "/($search)/i",
                '<span style="background-color: rgba(13, 110, 253, 0.2); border-radius: 4px;">$1</span>',
                e($t->title)
            );
        }

        return view('teachers.topics.list', compact('groupSubject', 'topics', 'search'));
    }

    // Mavzular uchun Gurux qidirish
    public function allTopicsSearch(Request $request)
    {
        $teacherId = auth()->id();
        $search = $request->input('search');
    
        if (empty($search)) {
            return redirect()->route('all.topics');
        }
    
        $groupSubjects = GroupSubject::with(['group', 'subject', 'topics'])
            ->where('teacher_id', $teacherId)
            ->whereHas('group', function ($query) use ($search) {
                $query->where('group_name', 'like', "%{$search}%");
            })
            ->get();
    
        // 🔍 Qidirilgan so‘zni highlight qilish (HTML-ni e() bilan qamralmang!)
        foreach ($groupSubjects as $gs) {
            $gs->group->group_name = preg_replace(
                "/(" . preg_quote($search, '/') . ")/i",
                '<span style="background-color: rgba(13, 110, 253, 0.2); border-radius:4px;">$1</span>',
                $gs->group->group_name
            );
        }
    
        return view('teachers.topics.all-topics', compact('groupSubjects', 'search', 'teacherId'));
    }
    
    
    

    public function teacherTopicEdit(Topic $topic)
    {
        $groupSubject = $topic->groupSubject;
        $topics = $groupSubject->topics()->get();

        return view('teachers.topics.edit', compact('topic', 'topics', 'groupSubject'));
    }

    public function teacherTopicUpdate(Request $request, Topic $topic)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file_path'  => 'nullable|file',
        ]);
    
        if ($request->hasFile('file_path')) {
            // eski faylni o‘chirish
            if ($topic->file_path && Storage::exists('topics/'.$topic->file_path)) {
                Storage::delete('topics/'.$topic->file_path);
            }
    
            $file = $request->file('file_path');
    
            // original nomini olish
            $originalName = $file->getClientOriginalName();
    
            // Faylni asl nomi bilan saqlash
            $file->storeAs('topics', $originalName, 'public');
    
            // Bazaga faqat fayl nomini yozamiz
            $topic->file_path = $originalName;
        }
    
        $topic->title = $request->title;
        $topic->save();
    
        return redirect()->route('topics.showByGroupSubject', $topic->group_subject_id)
            ->with('success', 'Mavzu yangilandi!');
    }

    public function teacherTopicDestroy(Topic $topic)
    {
        // Faylni ham o‘chirish
        if ($topic->file_path && Storage::exists($topic->file_path)) {
            Storage::delete($topic->file_path);
        }

        $topic->delete();

        return redirect()->route('topics.showByGroupSubject', $topic->group_subject_id)
            ->with('success', 'Mavzu o‘chirildi!');
    }
    

    public function showByGroupSubject($groupSubjectId)
    {
        $groupSubject = GroupSubject::with('topics.user')->findOrFail($groupSubjectId);
    
        // Agar view $topics kutsa:
        $topics = $groupSubject->topics()->with('user')->latest()->get();
    
        return view('teachers.topics.list', compact('groupSubject', 'topics'));
    }
    


    public function searchGroupTopics(Request $request, Topic $topic)
    {
        $search = $request->input('search');
    
        // `$groupSubject`ni olish
        $groupSubject = $topic->groupSubject;
    
        // Agar qidiruv bo‘sh bo‘lsa, asosiy sahifaga qaytadi
        if (empty($search)) {
            return redirect()->route('topics.index', $groupSubject->id);
        }
    
        // Faqat shu groupSubjectga tegishli mavzularni qidirish
        $topics = Topic::where('group_subject_id', $groupSubject->id)
            ->where('title', 'like', "%{$search}%")
            ->get();
    
        // Highlight qismi
        foreach ($topics as $t) {
            $t->title = preg_replace(
                "/($search)/i",
                '<span style="background-color: rgba(13, 110, 253, 0.2); border-radius: 4px;">$1</span>',
                e($t->title)
            );
        }
    
        // `topics.index` sahifasiga qaytamiz
        return view('groups.groupSubject.topics.index', compact('topics', 'search', 'groupSubject'));
    }
    
}
