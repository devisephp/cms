<?php

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class DvsUser extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * Users table
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Don't show password fields
     *
     * @var array
     */
    protected $hidden = array('');

    /**
     * Set the soft delete to true
     *
     * @var boolean
     */
    protected $softDelete = true;

    /**
     * Defines belongs to many DvsGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany('DvsGroup', 'group_user', 'user_id', 'group_id');
    }
}