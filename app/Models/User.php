<?php

/**
 * Format penulisan fungsi
 *
 * 1. Nama fungsi RELATION harus menggunakan PascalCase. Agar membedakannya dengan nama kolom.
 * 2. Parameter fungsi harus didefinisikan dengan tipe data yang jelas.
 * 3. Gunakan penamaan yang deskriptif untuk fungsi dan parameter.
 *
 * Contoh:
 *
 * public function SomeRelations()
 * {
 *   return $this->hasMany(SomeRelation::class);
 * }
 */

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Models\Feature;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'photo',
        'is_active',
        'role_id',
        'status',
        'bio',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->role_id) {
                $user->roles()->attach($user->role_id);
            }
        });
        
        static::updated(function ($user) {
            if ($user->isDirty('role_id') && $user->role_id) {
                $user->roles()->syncWithoutDetaching([$user->role_id]);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::needsRehash($value) ? bcrypt($value) : $value;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Legacy accessor for backward compatibility.
     * Returns the active role or first role found.
     */
    public function getRoleAttribute()
    {
        return $this->active_role ?? $this->roles->first();
    }

    /**
     * Get the currently active role context.
     * Synchronizes automatically with the accessed URL prefix or active session.
     */
    public function getActiveRoleAttribute()
    {
        if ($this->roles->isEmpty()) {
            return null;
        }

        // 1. Auto-detect from URL prefix if valid for this user
        if (request()) {
            $prefixRoleMap = [
                'superadmin' => 'super_admin',
                'teacher' => 'teacher',
                'administrationadmin' => 'administration_admin',
                'student' => 'student',
                'studentregistrant' => 'student_registrant',
                'treasurer' => 'treasurer',
                'parent' => 'parent',
                'facilitiesadmin' => 'facilities_admin',
            ];

            foreach ($prefixRoleMap as $prefix => $roleCode) {
                if (request()->is($prefix . '*') && $this->hasRole($roleCode)) {
                    if (session('active_role') !== $roleCode) {
                        session(['active_role' => $roleCode]);
                    }
                    return $this->roles->firstWhere('code', $roleCode);
                }
            }
        }

        // 2. Read from session if set and valid
        $sessionRoleCode = session('active_role');
        if ($sessionRoleCode && $this->hasRole($sessionRoleCode)) {
            return $this->roles->firstWhere('code', $sessionRoleCode);
        }

        // 3. Fallback: prioritize super_admin if user has it, otherwise first role
        if ($this->hasRole('super_admin')) {
            return $this->roles->firstWhere('code', 'super_admin');
        }

        return $this->roles->first();
    }

    /**
     * Get the active role's code string.
     */
    public function getActiveRoleCodeAttribute()
    {
        return $this->active_role?->code ?? $this->roles->first()?->code;
    }

    public function hasRole($roleCode)
    {
        return $this->roles->contains('code', $roleCode);
    }

    public function hasAnyRole($roleCodes)
    {
        if (is_array($roleCodes)) {
            foreach ($roleCodes as $code) {
                if ($this->hasRole($code)) {
                    return true;
                }
            }
        } else {
            return $this->hasRole($roleCodes);
        }
        return false;
    }

    private function getConsistentColor()
    {
        $hash = md5($this->name ?? 'Averroes');
        $color = substr($hash, 0, 6);

        return $color;
    }
    public function getPhotoAttribute($value)
    {
        if (!empty($value) && !is_null($value)) {
            return $value;
        }
        $color = $this->getConsistentColor();
        $name = $this->name ?? 'Averroes';

        return "https://api.dicebear.com/6.x/initials/svg?seed=" . urlencode($name) . "&backgroundColor=" . $color;
    }

    public function Permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function getPermissionCodes()
    {
        if ($this->hasRole('super_admin')) {
            return Feature::pluck('code');
        }
        if ($this->is_active == true) {
            $codes = $this->Permissions
                ? $this->Permissions->pluck('Feature.code')
                : collect([]);

            if ($codes->contains('all_feature')) {
                return Feature::pluck('code');
            }
            return $codes;
        } else {
            return collect([]);
        }
    }
    public function Student()
    {
        return $this->hasOne(Student::class)->withoutGlobalScope('excludeSuperAdmin');
    }
    public function Teacher()
    {
        return $this->hasOne(Teacher::class)->withoutGlobalScope('excludeSuperAdmin');
    }
    public function StudentRegistrant()
    {
        return $this->hasOne(StudentRegistrant::class);
    }
    public function PushSubscriptions()
    {
        return $this->hasMany(PushSubscription::class);
    }
}
