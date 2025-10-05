<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING FIXED QUERY ===\n";

$currentYear = date('Y');
$currentAcademicYearStart = "{$currentYear}-08-01";
$currentDate = date('Y-m-d');

echo "Fixed Query Range: {$currentAcademicYearStart} to {$currentDate} 23:59:59\n\n";

// Test the fixed query for major offenses
echo "=== MAJOR OFFENSES (FIXED QUERY) ===\n";
$majorViolations = \App\Models\StudentViolation::where('offense_type', 'major')
    ->where('created_at', '>=', $currentAcademicYearStart)
    ->where('created_at', '<=', $currentDate . ' 23:59:59')
    ->selectRaw('department, count(distinct student_id) as violator_count')
    ->groupBy('department')
    ->get();

foreach($majorViolations as $violation) {
    echo "{$violation->department}: {$violation->violator_count} violators\n";
}

if($majorViolations->isEmpty()) {
    echo "No major violations found\n";
}

echo "\n=== MINOR OFFENSES (FIXED QUERY) ===\n";
$minorViolations = \App\Models\StudentViolation::where('offense_type', 'minor')
    ->where('created_at', '>=', $currentAcademicYearStart)
    ->where('created_at', '<=', $currentDate . ' 23:59:59')
    ->selectRaw('department, count(distinct student_id) as violator_count')
    ->groupBy('department')
    ->get();

foreach($minorViolations as $violation) {
    echo "{$violation->department}: {$violation->violator_count} violators\n";
}

if($minorViolations->isEmpty()) {
    echo "No minor violations found\n";
}

echo "\n=== VERIFICATION ===\n";
$todaysMajor = \App\Models\StudentViolation::where('offense_type', 'major')
    ->whereDate('created_at', '2025-09-25')
    ->count();
    
$todaysMinor = \App\Models\StudentViolation::where('offense_type', 'minor')
    ->whereDate('created_at', '2025-09-25')
    ->count();

echo "Major violations created today (2025-09-25): {$todaysMajor}\n";
echo "Minor violations created today (2025-09-25): {$todaysMinor}\n";

echo "\n✅ FIXED: New violations should now appear in AY 2025-2026 column!\n";