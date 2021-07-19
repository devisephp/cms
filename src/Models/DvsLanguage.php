<?php

namespace Devise\Models;

class DvsLanguage extends Model
{
    protected $table = 'dvs_languages';

    public $fillable = ['code'];

    public function pages()
    {
        return $this->hasMany('DvsPage', 'language_id');
    }

    public function getNameAttribute()
    {
        return trans('devise::languages.' . $this->code);
    }

    public static function getCodesArray()
    {
        return [
            'aa', 'ab', 'af', 'ak', 'sq', 'am', 'ar', 'an', 'hy', 'as', 'av', 'ae', 'ay', 'az', 'ba', 'bm', 'eu', 'be', 'bn',
            'bh', 'bi', 'bo', 'bs', 'br', 'bg', 'my', 'ca', 'cs', 'ch', 'ce', 'zh', 'cu', 'cv', 'kw', 'co', 'cr', 'cy', 'cs',
            'da', 'de', 'dv', 'nl', 'dz', 'el', 'en', 'eo', 'et', 'eu', 'ee', 'fo', 'fa', 'fj', 'fi', 'fr', 'ka', 'de', 'gd',
            'ga', 'gl', 'gv', 'el', 'gn', 'gu', 'ht', 'ha', 'he', 'hz', 'hi', 'ho', 'hr', 'hu', 'hy', 'ig', 'is', 'io', 'ii',
            'iu', 'ie', 'ia', 'id', 'ik', 'is', 'it', 'jv', 'ja', 'kl', 'kn', 'ks', 'ka', 'kr', 'kk', 'km', 'ki', 'rw', 'ky',
            'kv', 'kg', 'ko', 'kj', 'ku', 'lo', 'la', 'lv', 'li', 'ln', 'lt', 'lb', 'lu', 'lg', 'mk', 'mh', 'ml', 'mi', 'mr',
            'ms', 'mk', 'mg', 'mt', 'mn', 'mi', 'ms', 'my', 'na', 'nv', 'nr', 'nd', 'ng', 'ne', 'nl', 'nn', 'nb', 'no', 'ny',
            'oc', 'oj', 'or', 'om', 'os', 'pa', 'fa', 'pi', 'pl', 'pt', 'ps', 'qu', 'rm', 'ro', 'ro', 'rn', 'ru', 'sg', 'sa',
            'si', 'sk', 'sk', 'sl', 'se', 'sm', 'sn', 'sd', 'so', 'st', 'es', 'sq', 'sc', 'sr', 'ss', 'su', 'sw', 'sv', 'ty',
            'ta', 'tt', 'te', 'tg', 'tl', 'th', 'bo', 'ti', 'to', 'tn', 'ts', 'tk', 'tr', 'tw', 'ug', 'uk', 'ur', 'uz', 've',
            'vi', 'vo', 'cy', 'wa', 'wo', 'xh', 'yi', 'yo', 'za', 'zh', 'zu'
        ];
    }
}