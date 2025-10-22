<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\Week;
use Carbon\Carbon;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        // --- parametrlar (xohlasang ko'paytirish/loop qilish mumkin)
        $fallStart   = '2025-09-08';
        $fallEnd     = '2025-12-28';
        $springStart = '2026-01-12';
        $springEnd   = '2026-05-24';

        $programId       = 1;
        $academicYearId  = 2;
        $studyDuration   = 4;
        $totalSemesters  = 8;
        $isGraduated     = false;

        $academicYear = AcademicYear::findOrFail($academicYearId);
        $startYear = (int) explode('-', $academicYear->name)[0];
        $endYear   = $startYear + $studyDuration;

        // --- Group yaratamiz (faqat mavjud ustunlarga yozamiz)
        $group = Group::create([
            "group_name"        => "AT 76-33",
            "full_group_name"   => "asdfghjkssadsa",
            "program_id"        => $programId,
            "education_type"    => "Bakalavr",
            "study_duration"    => $studyDuration,
            "academic_year_id"  => $academicYearId,
            "total_semesters"   => $totalSemesters,
            "is_graduated"      => $isGraduated,
            "start_year"        => $startYear,
            "end_year"          => $endYear,
            "current_semester"  => 1,
        ]);

        // --- Semestr va haftalarni yaratamiz (seeder ichida)
        $this->createSemesters($group, $fallStart, $fallEnd, $springStart, $springEnd);
        $this->createWeeks($group, $fallStart, $fallEnd, $springStart, $springEnd);

        // --- hozirgi haftaga qarab current_semester yangilash
        $currentWeek = Week::where('group_id', $group->id)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();

        $group->current_semester = $currentWeek ? $currentWeek->semester->semester_number : 1;
        $group->save();
    }

    private function createSemesters(Group $group, $fallStart, $fallEnd, $springStart, $springEnd)
    {
        // avvalgi semestrlarni o'chirish (agar mavjud bo'lsa)
        Semester::where('group_id', $group->id)->delete();

        for ($i = 1; $i <= $group->total_semesters; $i++) {
            $courseYearOffset = floor(($i - 1) / 2);

            if ($i % 2 != 0) { // odd -> fall
                $start_date = Carbon::parse($fallStart)->addYears($courseYearOffset);
                $end_date   = Carbon::parse($fallEnd)->addYears($courseYearOffset);
            } else { // even -> spring
                $start_date = Carbon::parse($springStart)->addYears($courseYearOffset);
                $end_date   = Carbon::parse($springEnd)->addYears($courseYearOffset);
            }

            $academicStartYear = $group->start_year + $courseYearOffset;
            $academicEndYear   = $academicStartYear + 1;

            Semester::create([
                'group_id'        => $group->id,
                'semester_number' => $i,
                'name'            => $i . '-semestr',
                'academic_year'   => $academicStartYear . '-' . $academicEndYear,
                'start_date'      => $start_date->format('Y-m-d'),
                'end_date'        => $end_date->format('Y-m-d'),
            ]);
        }
    }

    private function createWeeks(Group $group, $fallStart, $fallEnd, $springStart, $springEnd)
    {
        // avvalgi haftalarni o'chirish
        Week::where('group_id', $group->id)->delete();

        $academicYear = AcademicYear::findOrFail($group->academic_year_id);
        $startAcademic = (int) explode('-', $academicYear->name)[0];

        // semestr davrlarini tuzamiz
        $periods = [];
        for ($s = 1; $s <= $group->total_semesters; $s++) {
            $yearOffset = intdiv($s - 1, 2);

            if ($s % 2 === 1) { // fall
                $year  = $startAcademic + $yearOffset;
                $start = Carbon::parse($fallStart)->copy()->year($year);
                $end   = Carbon::parse($fallEnd)->copy()->year($year);
            } else { // spring
                $year  = $startAcademic + $yearOffset + 1;
                $start = Carbon::parse($springStart)->copy()->year($year);
                $end   = Carbon::parse($springEnd)->copy()->year($year);
            }

            $periods[] = [
                'sem'   => $s,
                'start' => $start,
                'end'   => $end,
            ];
        }

        $overallStart = $periods[0]['start']->copy();
        $overallEnd   = $periods[count($periods) - 1]['end']->copy();

        $weekNumber = 1;
        $current = $overallStart->copy();

        while ($current->lte($overallEnd)) {
            $weekStart = $current->copy();
            $weekEnd   = $current->copy()->addDays(6);
            if ($weekEnd->gt($overallEnd)) {
                $weekEnd = $overallEnd->copy();
            }

            $semesterForWeek = null;
            $weekType = 'Tatil';

            foreach ($periods as $p) {
                if ($weekStart->gte($p['start']) && $weekStart->lte($p['end'])) {
                    $semesterForWeek = $p['sem'];
                    $weekType = "Nazariy talim";
                    break;
                }
            }

            if (!$semesterForWeek) {
                foreach ($periods as $p) {
                    if ($p['start']->gt($weekStart)) {
                        $semesterForWeek = $p['sem'];
                        break;
                    }
                }
                $semesterForWeek = $semesterForWeek ?? $periods[count($periods) - 1]['sem'];
            }

            $semester = Semester::where('group_id', $group->id)
                ->where('semester_number', $semesterForWeek)
                ->first();

            if (!$semester) {
                // agar semestr topilmasa — keyingi haftaga o'tamiz
                $current->addWeek();
                continue;
            }

            Week::create([
                'group_id'      => $group->id,
                'semester_id'   => $semester->id,
                'week_number'   => $weekNumber,
                'start_date'    => $weekStart->toDateString(),
                'end_date'      => $weekEnd->toDateString(),
                'academic_year' => $semester->academic_year,
                'week_type'     => $weekType,
            ]);

            $weekNumber++;
            $current->addWeek();
        }
    }
}
