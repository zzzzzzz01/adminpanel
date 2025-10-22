<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    
        protected $fillable = ['group_subject_id', 'lesson_pair_id', 'week_id', 'group_id', 'auditorium_id', 'session_id', 'semester_id', 'date'];

        public function teacher() {
            return $this->belongsTo(User::class, 'teacher_id');
        }

        public function subject() {
            return $this->belongsTo(Subject::class);
        }

        public function weekday(){
            return $this->belongsTo(Weekday::class);
        }

        public function group(){
            return $this->belongsTo(Group::class);
        }

        public function session(){
            return $this->belongsTo(Session::class);
        }

        public function week()
        {
            return $this->belongsTo(Week::class);
        }

        public function attendances() {
            return $this->hasMany(Attendance::class);
        }

        public function semester()
        {
            return $this->belongsTo(Semester::class);
        }

        public function gradeJournals()
        {
            return $this->hasMany(GradeJournal::class);
        }

        public function journal()
        {
            return $this->belongsTo(Journal::class);
        }

        public function grades()
        {
            return $this->hasMany(Grade::class);
        }

        public function groupSubject()
        {
            return $this->belongsTo(GroupSubject::class, 'group_subject_id');
        }

        public function lessonPair()
        {
            return $this->belongsTo(LessonPair::class, 'lesson_pair_id');
        }

        public function auditorium()
        {
            return $this->belongsTo(Auditorium::class, 'auditorium_id');
        }

        
}
