<?php namespace Devise\Support;

use Illuminate\Support\Facades\DB;

class Database
{

    public static function connected($name = null)
    {
        try
        {
            DB::connection($name)->getPdo();

            return true;
        } catch (\Exception $e)
        {
            return false;
        }
    }
}