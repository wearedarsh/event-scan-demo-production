<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Models\Registration;
use App\Models\FeedbackFormSubmission;
use App\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\CustomResetPasswordNotification;
use App\Models\EmailBroadcast;

class User extends Authenticatable
{

    use SoftDeletes;
    use HasFactory, Notifiable;

    public function registrations(){
        return $this->hasMany(Registration::class);
    }

    public function feedbackFormSubmissions(){
        return $this->hasMany(FeedbackFormSubmission::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }

    public function emailBroadcasts(){
        return $this->hasMany(EmailBroadcast::class);
    }

    public function canAccessDashboard(): bool
    {
        return $this->active;
    }

    
    /** @use HasFactory<\Database\Factories\UserFactory> */
    

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'active',
        'email_marketing_opt_in',
        'role_id',
        'is_admin',
        'active',
        'title',
        'receives_admin_notifications',
        'email_marketing_subscriber_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopeAdminNotificationRecipients($query)
    {
        return $query->where('active', true)
            ->where('receives_admin_notifications', true)
            ->where('is_admin', true)
            ->get();
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }
}
