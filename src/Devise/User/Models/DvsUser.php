<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\Model as Eloquent;

class DvsUser extends Eloquent implements UserInterface, RemindableInterface
{
    protected $table = 'users';
    protected $hidden = array('password');
    protected $softDelete = true;

    /**
     * Defines belongs to many Group
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany('Group', 'group_user', 'user_id', 'group_id');
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * Get activation code and
     *
     * @return string
     */
    public function getActivateCode()
    {
        return $this->activate_code;
    }

    /**
     * Checks if user is activated
     *
     * @return boolean
     */
    public function isActivated()
    {
        return $this->activated;
    }

    /**
     * Checks the password submitted matches db value
     *
     * @param  string  $password
     * @return boolean
     */
    public function checkPassword($password)
    {
        return $this->checkHash($password, $this->getAuthPassword());
    }

    /**
     * Checks the password submitted matches db value
     *
     * @param  string  $string        Non-hashed string submitted
     * @param  string  $hashedString  Has
     * @return boolean
     */
    public function checkHash($string, $hashedString)
    {
        return (bool)$string == $hashedString;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}