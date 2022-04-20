<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'surname', 'firstname', 'username','phone','gender_id','marital_status_id', 'email', 'password', 'active', 'role_id', 'title_id', 'address', 'user_image'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
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

    public function role(){

        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    public function gender(){

        return $this->belongsTo('App\Gender');
    }

    public function maritalStatus(){

        return $this->belongsTo('App\MaritalStatus');
    }

    public function title(){

        return $this->belongsTo('App\Title');
    }

    public function qualifications(){

        return $this->hasMany('App\Qualification');
    }

    private function checkIfUserHasRole($need_role){

        return (strtolower($need_role) == strtolower($this->role->name)) ? true :null; 
    }


    public function hasRole($roles){

        if(is_array($roles)){

            foreach ($roles as $need_role) {
                
                if($this->checkIfUserHasRole($need_role)){

                    return true;
                }
            }
        }else{

            return $this->checkIfUserHasRole($roles);
        }

        return false;
    }
}
