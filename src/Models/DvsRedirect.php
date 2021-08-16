<?php

namespace Devise\Models;

class DvsRedirect extends Model
{
    public $fillable = ['site_id', 'from_url', 'to_url'];

    protected $table = 'dvs_redirects';

    protected $attributes = [
        'type' => 301
    ];

    public function setFromUrlAttribute($value)
    {
        if (strpos($value, 'http') === false) {
            $noSlashes = trim($value, '/');
            $value = '/' . $noSlashes;
        }

        $this->attributes['from_url'] = $value;
    }

    /**
     * @return string
     */
    public function newUrl($request)
    {
        $query = '';
        $allinput = [];
        $urlParts = parse_url($this->to_url);

        if (isset($urlParts['query'])) {
            parse_str($urlParts['query'], $allinput);
        }

        $input = $request->all();
        $allinput = array_merge($allinput, $input);

        if ($allinput) {
            $query = '?' . http_build_query($allinput);
        }

        $parts = explode('?', $this->to_url);

        return $parts[0] . $query;
    }
}