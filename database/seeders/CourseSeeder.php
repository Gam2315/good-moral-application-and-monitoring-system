<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing courses
        Course::truncate();

        // SITE Department Courses
        $siteCourses = [
            ['BSIT', 'Bachelor of Science in Information Technology'],
            ['BLIS', 'Bachelor of Library and Information Science'],
            ['BS ENSE', 'Bachelor of Science in Electronics Engineering'],
            ['BS CpE', 'Bachelor of Science in Computer Engineering'],
            ['BSCE', 'Bachelor of Science in Civil Engineering']
        ];

        foreach ($siteCourses as $index => $course) {
            Course::create([
                'course_code' => $course[0],
                'course_name' => $course[1],
                'department' => 'SITE',
                'department_name' => 'School of Information Technology and Engineering',
                'is_active' => true,
                'sort_order' => $index + 1
            ]);
        }

        // SBAHM Department Courses
        $sbahmCourses = [
            ['BSA', 'Bachelor of Science in Accountancy'],
            ['BSE', 'Bachelor of Science in Entrepreneurship'],
            ['BSBAMM', 'Bachelor of Science in Business Administration Major in Marketing Management'],
            ['BSBA MFM', 'Bachelor of Science in Business Administration Major in Financial Management'],
            ['BSBA MOP', 'Bachelor of Science in Business Administration Major in Operations Management'],
            ['BSMA', 'Bachelor of Science in Management Accounting'],
            ['BSHM', 'Bachelor of Science in Hospitality Management'],
            ['BSTM', 'Bachelor of Science in Tourism Management'],
            ['BSPDMI', 'Bachelor of Science in Public Administration Major in Development Management and Innovation']
        ];

        foreach ($sbahmCourses as $index => $course) {
            Course::create([
                'course_code' => $course[0],
                'course_name' => $course[1],
                'department' => 'SBAHM',
                'department_name' => 'School of Business Administration and Hospitality Management',
                'is_active' => true,
                'sort_order' => $index + 1
            ]);
        }

        // SASTE Department Courses
        $sasteCourses = [
            ['BAELS', 'Bachelor of Arts in English Language Studies'],
            ['BS Psych', 'Bachelor of Science in Psychology'],
            ['BS Bio', 'Bachelor of Science in Biology'],
            ['BSSW', 'Bachelor of Science in Social Work'],
            ['BSPA', 'Bachelor of Science in Public Administration'],
            ['BS Bio MB', 'Bachelor of Science in Biology Major in Microbiology'],
            ['BSEd', 'Bachelor of Secondary Education'],
            ['BEEd', 'Bachelor of Elementary Education'],
            ['BPEd', 'Bachelor of Physical Education']
        ];

        foreach ($sasteCourses as $index => $course) {
            Course::create([
                'course_code' => $course[0],
                'course_name' => $course[1],
                'department' => 'SASTE',
                'department_name' => 'School of Arts, Sciences, Teacher Education',
                'is_active' => true,
                'sort_order' => $index + 1
            ]);
        }

        // SNAHS Department Courses
        $snahsCourses = [
            ['BSN', 'Bachelor of Science in Nursing'],
            ['BSPh', 'Bachelor of Science in Pharmacy'],
            ['BSMT', 'Bachelor of Science in Medical Technology'],
            ['BSPT', 'Bachelor of Science in Physical Therapy'],
            ['BSRT', 'Bachelor of Science in Radiologic Technology']
        ];

        foreach ($snahsCourses as $index => $course) {
            Course::create([
                'course_code' => $course[0],
                'course_name' => $course[1],
                'department' => 'SNAHS',
                'department_name' => 'School of Nursing and Allied Health Sciences',
                'is_active' => true,
                'sort_order' => $index + 1
            ]);
        }

        // SOM Department Courses
        Course::create([
            'course_code' => 'MD',
            'course_name' => 'Doctor of Medicine',
            'department' => 'SOM',
            'department_name' => 'School of Medicine',
            'is_active' => true,
            'sort_order' => 1
        ]);

        // GRADSCH Department Courses
        $gradschCourses = [
            ['MA', 'Master of Arts'],
            ['MS', 'Master of Science'],
            ['PhD', 'Doctor of Philosophy'],
            ['MBA', 'Master of Business Administration'],
            ['MPA', 'Master of Public Administration']
        ];

        foreach ($gradschCourses as $index => $course) {
            Course::create([
                'course_code' => $course[0],
                'course_name' => $course[1],
                'department' => 'GRADSCH',
                'department_name' => 'Graduate School',
                'is_active' => true,
                'sort_order' => $index + 1
            ]);
        }

        $this->command->info('Courses seeded successfully!');
        $this->command->info('Total courses created: ' . Course::count());
    }
}
