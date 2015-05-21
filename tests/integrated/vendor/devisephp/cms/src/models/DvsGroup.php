<?php


class DvsGroup extends Eloquent
{
    protected $table = 'groups';

   /**
     * Defines belongs to many User
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users() {
        return $this->belongsToMany('DvsUser', 'group_user', 'group_id', 'user_id');
    }
}