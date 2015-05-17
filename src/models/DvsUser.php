<?php

use Devise\Support\Sortable\Sortable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class DvsUser extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Sortable, SoftDeletes;

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
     * Deleted at is a date too...
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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