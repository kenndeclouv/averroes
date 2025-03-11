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
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    public function Role()
    {
        return $this->belongsTo(Role::class);
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
        if ($this->Role->code == 'super_admin') {
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
        return $this->hasOne(Student::class);
    }
    public function Teacher()
    {
        return $this->hasOne(Teacher::class);
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
