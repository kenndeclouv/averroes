<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Student extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('excludeSuperAdmin', function (Builder $builder) {
            $builder->where('id', '!=', 1);
        });
    }

    /**
     * Validation rules for Student model.
     * Use this in your controller or form request for validation.
     */
    public static function rules($id = null)
    {
        return [
            // other rules...
            'nis' => [
                'required',
                'string',
                Rule::unique('students', 'nis')->ignore($id),
            ],
        ];
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function Room()
    {
        return $this->belongsTo(Room::class);
    }
    public function Classes()
    {
        return $this->belongsTo(Classes::class);
    }
    public function StudentPermits()
    {
        return $this->hasMany(StudentPermit::class);
    }
    public function getAttachmentFamilyRegisterAttribute($value)
    {
        if (!empty($value) && !is_null($value)) {
            return asset("storage/uploads/family_registers/" . $value);  // Menggunakan helper asset() untuk path file
        }
    }
    public function getAttachmentBirthCertificateAttribute($value)
    {
        if (!empty($value) && !is_null($value)) {
            return asset("storage/uploads/birth_certificates/" . $value);  // Menggunakan helper asset() untuk path file
        }
    }
    public function getAttachmentDiplomaAttribute($value)
    {
        if (!empty($value) && !is_null($value)) {
            return asset("storage/uploads/diplomas/" . $value);  // Menggunakan helper asset() untuk path file
        }
    }
    public function getAttachmentFatherIdentityCardAttribute($value)
    {
        if (!empty($value) && !is_null($value)) {
            return asset("storage/uploads/father_identity_cards/" . $value);  // Menggunakan helper asset() untuk path file
        }
    }
    public function getAttachmentMotherIdentityCardAttribute($value)
    {
        if (!empty($value) && !is_null($value)) {
            return asset("storage/uploads/mother_identity_cards/" . $value);  // Menggunakan helper asset() untuk path file
        }
    }
}
