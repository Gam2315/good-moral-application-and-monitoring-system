<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DETAILED TIMESTAMP ANALYSIS ===\n";

$currentYear = date('Y');
$currentAcademicYearStart = "{$currentYear}-08-01";
$currentDate = date('Y-m-d');

echo "Range Start: {$currentAcademicYearStart} 00:00:00\n";
echo "Range End: {$currentDate} 23:59:59\n\n";

// Get the most recent violations with exact timestamps
$recentViolations = \App\Models\StudentViolation::orderBy('created_at', 'desc')
    ->limit(10)
    ->get(['id', 'student_id', 'offense_type', 'department', 'created_at']);

echo "=== RECENT VIOLATIONS WITH EXACT TIMESTAMP COMPARISON ===\n";
foreach($recentViolations as $v) {
    $createdDate = $v->created_at->format('Y-m-d H:i:s');
    $createdDateOnly = $v->created_at->format('Y-m-d');
    
    // Test different comparison methods
    $isInRangeDateTime = ($v->created_at >= $currentAcademicYearStart && $v->created_at <= $currentDate);
    $isInRangeDateString = ($createdDateOnly >= substr($currentAcademicYearStart, 0, 10) && $createdDateOnly <= $currentDate);
    
    echo "ID: {$v->id}\n";
    echo "  Created: {$createdDate}\n";
    echo "  Date Only: {$createdDateOnly}\n";
    echo "  >= {$currentAcademicYearStart}: " . ($v->created_at >= $currentAcademicYearStart ? "YES" : "NO") . "\n";
    echo "  <= {$currentDate}: " . ($v->created_at <= $currentDate ? "YES" : "NO") . "\n";
    echo "  Date string >= {$currentAcademicYearStart}: " . ($createdDateOnly >= substr($currentAcademicYearStart, 0, 10) ? "YES" : "NO") . "\n";
    echo "  Date string <= {$currentDate}: " . ($createdDateOnly <= $currentDate ? "YES" : "NO") . "\n";
    echo "  Should be in range: " . (($createdDateOnly >= '2025-08-01' && $createdDateOnly <= '2025-09-25') ? "YES" : "NO") . "\n";
    echo "  ----\n";
}

// Test the exact query from the controller
echo "\n=== TESTING CONTROLLER QUERY ===\n";
echo "Query: WHERE created_at >= '{$currentAcademicYearStart}' AND created_at <= '{$currentDate}'\n";

$testQuery = \App\Models\StudentViolation::where('created_at', '>=', $currentAcademicYearStart)
    ->where('created_at', '<=', $currentDate)
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get(['id', 'created_at']);

echo "Results:\n";
foreach($testQuery as $v) {
    echo "  ID: {$v->id}, Created: {$v->created_at}\n";
}

echo "\n=== POTENTIAL ISSUE ===\n";
echo "The query might be using string comparison instead of datetime comparison.\n";
echo "Current date '{$currentDate}' might be interpreted as '{$currentDate} 00:00:00'\n";
echo "But violations created later in the day have timestamps like '2025-09-25 18:53:49'\n";
echo "Solution: Use end-of-day timestamp or BETWEEN clause\n";