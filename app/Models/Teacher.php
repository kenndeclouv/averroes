<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['name', 'full_name', 'phone', 'birth_date', 'birth_place', 'address', 'room_id', 'classes_id', 'gender', 'last_degree'];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('excludeSuperAdmin', function (Builder $builder) {
            $builder->where('id', '!=', 1);
        });
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function Room()
    {
        return $this->belongsTo(Room::class);
    }
    public function teacherTypes()
    {
        return $this->belongsToMany(TeacherType::class, 'teacher_has_types')->withPivot('description');
    }
    public function getFunctionalTypesAttribute()
    {
        return $this->teacherTypes
            ->where('type', 'functional_position')
            ->map(function ($type) {
                // Cek apakah slug-nya "functional_position-lainnya"
                if ($type->slug === 'functional_position-lainnya') {
                    // Ambil deskripsi dari tabel teacher_has_types
                    $description = $type->pivot->description ?? '';
                    return "Lainnya ($description)";
                }
                return $type->name;
            })
            ->toArray() ?? "-";
    }

    public function getTeachingMandatoryTypesAttribute()
    {
        return $this->teacherTypes
            ->where('type', 'teaching_mandatory')
            ->map(function ($type) {
                // Cek apakah slug-nya "teaching_mandatory-lainnya"
                if ($type->slug === 'teaching_mandatory-lainnya') {
                    // Ambil deskripsi dari tabel teacher_has_types
                    $description = $type->pivot->description ?? '';
                    return "Lainnya ($description)";
                }
                return $type->name;
            })
            ->toArray() ?? "-";
    }

    public function TeachingJournals()
    {
        return $this->hasMany(TeachingJournal::class);
    }
}
