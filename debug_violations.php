<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DEBUG: AY 2025-2026 Violation Detection ===\n";

// Replicate the exact logic from getTrendsAnalysisData()
$currentYear = date('Y');
$previousYear = $currentYear - 1;
$currentAcademicYearStart = "{$currentYear}-08-01";
$currentDate = date('Y-m-d');

echo "Current Date: " . date('Y-m-d H:i:s') . "\n";
echo "Current Year Variable: " . $currentYear . "\n";
echo "Previous Year Variable: " . $previousYear . "\n";
echo "Current Academic Year Start: " . $currentAcademicYearStart . "\n";
echo "Current Date for Query: " . $currentDate . "\n\n";

echo "=== Expected AY Assignments ===\n";
echo "AY 2023-2024: Aug 1, 2023 to Jul 31, 2024\n";
echo "AY 2024-2025: Aug 1, 2024 to Jul 31, 2025\n";
echo "AY 2025-2026: Aug 1, 2025 to Jul 31, 2026 ← CURRENT\n\n";

// Check total violations in database
$totalViolations = \App\Models\StudentViolation::count();
echo "Total violations in database: " . $totalViolations . "\n\n";

// Check violations in current AY 2025-2026 range
echo "=== MAJOR OFFENSES AY 2025-2026 ===\n";
$majorQuery = \App\Models\StudentViolation::where('offense_type', 'major')
    ->where('created_at', '>=', $currentAcademicYearStart)
    ->where('created_at', '<=', $currentDate);

echo "Query: WHERE offense_type = 'major' AND created_at >= '{$currentAcademicYearStart}' AND created_at <= '{$currentDate}'\n";
echo "Total major violations found: " . $majorQuery->count() . "\n";

$majorByDept = $majorQuery->selectRaw('department, count(distinct student_id) as violator_count')
    ->groupBy('department')
    ->get();

foreach($majorByDept as $dept) {
    echo "- {$dept->department}: {$dept->violator_count} violators\n";
}

echo "\n=== MINOR OFFENSES AY 2025-2026 ===\n";
$minorQuery = \App\Models\StudentViolation::where('offense_type', 'minor')
    ->where('created_at', '>=', $currentAcademicYearStart)
    ->where('created_at', '<=', $currentDate);

echo "Query: WHERE offense_type = 'minor' AND created_at >= '{$currentAcademicYearStart}' AND created_at <= '{$currentDate}'\n";
echo "Total minor violations found: " . $minorQuery->count() . "\n";

$minorByDept = $minorQuery->selectRaw('department, count(distinct student_id) as violator_count')
    ->groupBy('department')
    ->get();

foreach($minorByDept as $dept) {
    echo "- {$dept->department}: {$dept->violator_count} violators\n";
}

echo "\n=== RECENT VIOLATIONS (Last 5) ===\n";
$recentViolations = \App\Models\StudentViolation::orderBy('created_at', 'desc')
    ->limit(5)
    ->get(['id', 'student_id', 'offense_type', 'department', 'created_at']);

foreach($recentViolations as $v) {
    $isInRange = ($v->created_at >= $currentAcademicYearStart && $v->created_at <= $currentDate);
    $rangeStatus = $isInRange ? "✅ IN AY 2025-2026" : "❌ NOT IN RANGE";
    echo "ID: {$v->id}, Student: {$v->student_id}, Type: {$v->offense_type}, Dept: {$v->department}, Date: {$v->created_at} {$rangeStatus}\n";
}

echo "\n=== CONCLUSION ===\n";
if($majorQuery->count() > 0 || $minorQuery->count() > 0) {
    echo "✅ Violations found in AY 2025-2026 range\n";
    echo "If not showing in reports, check view/report generation logic\n";
} else {
    echo "❌ No violations found in AY 2025-2026 range\n";
    echo "New violations should have created_at >= '{$currentAcademicYearStart}'\n";
}