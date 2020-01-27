<?php

/**
 * Created by PhpStorm.
 * User: rle
 * Date: 27/04/18
 * Time: 07:20
 */
namespace App\Traits;


use App\Helpers\DataHelper;

trait UserTrait
{

    public function getEmail()
    {
        return $this->getAttribute( 'email' );
    }

    public function getShortEmail()
    {
        return str_limit($this->getEmail(), 20 );
    }

    public function getName()
    {
        return $this->getAttribute( 'name' );
    }

    public function getShortName()
    {
        return str_limit($this->getName(), 20 );
    }


    public function setCpfAttribute( $value )
    {
        return $this->attributes['cpf'] = DataHelper::getOnlyNumbers( $value );
    }

    public function getCpfFormattedAttribute()
    {
        return DataHelper::mask( $this->attributes['cpf'], '###.###.###-##' );
    }

    public function setRgAttribute( $value )
    {
        return $this->attributes['rg'] = DataHelper::getOnlyNumbers( $value );
    }

    public function getRgFormattedAttribute() {
        return DataHelper::mask( $this->attributes['rg'], '#.###.###-##' );
    }


    public function updatePassword($password)
    {
        return $this->update([
            'password' => bcrypt($password)
        ]);
    }

    public function is($role)
    {
        return ($this->getRole()->name == $role);
    }


    public function getShortRoleName()
    {
        return $this->getRole()->display_name;
    }

    public function getRole()
    {
        return $this->roles()->first();
    }

    public function itsMe($id)
    {
        return ($this->getAttribute('id') == $id);
    }

    /*
    public function getHomeRoute()
    {
        return $this->hasRole('admin') ? 'admin.index' : 'home';
    }

    public function getHomeUrl()
    {
        return route($this->getHomeRoute());
    }

    public function block()
    {
        $this->update(['blocked' => 0]);
        return $this->save();
    }

    public function unblock()
    {
        $this->update(['blocked' => 1]);
        return $this->save();
    }

    public function disable()
    {
        $admin_ids = Admin::active()->pluck('user_id');
        $users = self::whereIn('id', $admin_ids)->get();
        Notification::send($users, new NotifyAdminsRemovedClient($this->client));
        $this->active = 0;
        return $this->save();
    }

    public function enable()
    {
        $this->active = 1;
        return $this->save();
    }

    */
}
