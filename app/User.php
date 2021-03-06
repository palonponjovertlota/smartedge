<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Airlock\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reviewee_profile()
    {
        return $this->hasOne(RevieweeProfile::class, 'user_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function createQuiz($attributes)
    {
        return $this->quizzes()->create($attributes);
    }

    public function activeQuiz()
    {
        return $this->quizzes->where('completed_at', null)->first();
    }
}
