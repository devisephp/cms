<?php namespace Devise\Support;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class DevisePaginator
{
    /**
     * Create paginator
     *
     * @param  Illuminate\Support\Collection  $collection
     * @param  int     $total
     * @param  int     $perPage
     * @return string
     */
    public function make($collection, $total, $perPage)
    {
        return new LengthAwarePaginator($collection, $total, $perPage, Paginator::resolveCurrentPage(), ['path' => Paginator::resolveCurrentPath()]);
    }
}