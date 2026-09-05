<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'department',
        'departments',
        'bio',
        'image',
        'email',
        'twitter',
        'linkedin',
        'github',
        'skills',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'departments' => 'array',
        'skills'      => 'array',
        'status'      => 'boolean',
        'sort_order'  => 'integer',
    ];

    /**
     * Get the member's primary department (kept for backward compat).
     */
    public function getPrimaryDepartmentAttribute(): ?string
    {
        if (! empty($this->departments)) {
            return $this->departments[0];
        }
        return $this->department;
    }

    /**
     * Get all departments, falling back to the legacy single field.
     */
    public function getAllDepartmentsAttribute(): array
    {
        if (! empty($this->departments)) {
            return $this->departments;
        }
        return $this->department ? [$this->department] : [];
    }

    public function scopeVisible($query)
    {
        return $query->where('status', true)
            ->orderBy('sort_order');
    }

    public function scopeInDepartment($query, string $dept)
    {
        $dept = strtolower($dept);
        return $query->where(function ($q) use ($dept) {
            $q->whereJsonContains('departments', $dept)
              ->orWhereRaw('LOWER(department) = ?', [$dept]);
        });
    }
}
