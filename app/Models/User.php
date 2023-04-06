<?php

namespace App\Models;

use App\Enum\RoleEnum;
use App\Models\Traits\User\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;
use App\Traits\UtilsLogs;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, LogsActivity, UtilsLogs, UserScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'dni',
        'last_name',
        'email_verified_at',
        'rol_id',
        'status',
        'workshop_id',
        'password'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn (string $eventName) => "Usuario :  {$this->eventName($eventName)}")
            ->useLogName('Usuario')
            ->dontLogIfAttributesChangedOnly(['remember_token']);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->ip = request()->ip();
        $activity->user_agent = $this->nameDevicePlatorm();
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->last_name;
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => bcrypt($value),
        );
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    public function vehiculo()
    {
        return $this->hasMany(Vehicle::class);
    }

    //usuario inactivo
    public function inactive()
    {
        return $this->status == 2;
    }

    //taller
    public function workshopUser()
    {
        return $this->rol_id == 4 ? ' | Taller: ' . $this->workshop?->name : false;
    }

    /**
     * verificar usuario con rol de superadmin
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->rol_id === RoleEnum::SUPER_ADMIN;
    }

    /**
     * verificar usuario con rol de supervisor
     *
     * @return bool
     */
    public function isSupervisor()
    {
        return $this->rol_id === RoleEnum::SUPERVISOR;
    }

    /**
     * verificar usuario con rol de proveedor
     *
     * @return bool
     */
    public function isSupplier()
    {
        return $this->rol_id === RoleEnum::SUPPLIER;
    }

    /**
     * verificar usuario con rol de registrador
     *
     * @return bool
     */
    public function isRecorder()
    {
        return $this->rol_id === RoleEnum::RECORDER;
    }
}
