<?php

namespace App;

use App\Models\Role;
use App\Models\Profile;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use phpDocumentor\Reflection\Types\Collection;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', "role_id"
    ];

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

    /**
    * @return
    */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
    * @return
    */
    public function hasRoles(array $roles)
    {
        //dd( [$this->role->name, $roles] );
        foreach ($roles as $key => $role) {
            if ( $this->role->name == $role )
                return true;
        }

        return false;
    }


    public function campaigns()
    {
        return $this->belongsToMany('App\Models\Campaign', 'campaings_producers', 'user_id', 'campaign_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class)->withDefault();
    }

    /**
     * metodo para obtener los usuarios con role administradores
     * @return Builder
     */
    public function scopeGetAdministrators(Builder $query): Builder
    {
        return $query->whereHas('role', function($q){
            $q->whereName("Administrador");
        });
    }

    /**
     * metodo para obtener todos los usuarios activos
     * @return Builder
    */
    public function scopeGetAllActives(Builder $query)
    {
        return $query->where('status','=',1);
    }

    /**
     * Metodo para obtener usuarios a los que se les pueda hacer envio de notificacion
     * siempre y cuando cumplan la condicion de los parametros recibidos
     * @param string $class
     * @param string $method
     * @return Builder
    */
    public function scopeCanSentNotifications(Builder $query, string $class, string $method): Builder
    {
        return $query->whereHas('profile', function($query) use($class,$method){
            $query->whereHas('notifications', function ($q) use($class,$method){
                $q->where('class','=',$class)
                    ->where('method','=',$method);
            });
        });
    }
}
