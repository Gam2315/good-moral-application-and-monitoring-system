<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'course_name',
        'department',
        'department_name',
        'is_active',
        'description',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope to get only active courses
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get courses by department
     */
    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    /**
     * Get courses ordered by sort_order and course_name
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('course_name');
    }

    /**
     * Get all courses grouped by department
     */
    public static function getByDepartment($activeOnly = true)
    {
        $query = self::query();

        if ($activeOnly) {
            $query->active();
        }

        return $query->ordered()
            ->get()
            ->groupBy('department')
            ->map(function ($courses) {
                return $courses->pluck('course_name', 'course_code');
            });
    }

    /**
     * Get all courses as flat array (code => name)
     */
    public static function getAllCourses($activeOnly = true)
    {
        $query = self::query();

        if ($activeOnly) {
            $query->active();
        }

        return $query->ordered()
            ->pluck('course_name', 'course_code')
            ->toArray();
    }

    /**
     * Get departments with their full names
     */
    public static function getDepartments($activeOnly = true)
    {
        $query = self::query();

        if ($activeOnly) {
            $query->active();
        }

        return $query->select('department', 'department_name')
            ->distinct()
            ->orderBy('department')
            ->pluck('department_name', 'department')
            ->toArray();
    }
}
