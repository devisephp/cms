<?php

namespace Devise\Http\Requests\Pages;

use Devise\Http\Rules\ViewExists;
use Devise\Http\Requests\ApiRequest;
use Devise\Sites\SiteDetector;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CopyPage extends ApiRequest
{
    private $SiteDetector;

    /**
     * StorePage constructor.
     * @param SiteDetector $SiteDetector
     */
    public function __construct(SiteDetector $SiteDetector)
    {
        $this->SiteDetector = $SiteDetector;
        parent::__construct();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $site = $this->SiteDetector->current();

        return [
            'title' => 'required',
            'slug'  => [
                'required',
                Rule::unique('dvs_pages')->where(function ($query) use ($site) {
                    return $query->where('site_id', $site->id);
                })
            ]
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (request()->has('language_id'))
            {
                if ($this->targetLanguageAreadyExists())
                {
                    $validator->errors()->add('language_id', 'Page already has already been translated to this language');
                }
            } else
            {
                if ($this->pageToBeCopiedIsNotInDefaultLanguage())
                {
                    $validator->errors()->add('page_id', 'Only page in the default language can be copied.');
                }
            }
        });
    }

    public function targetLanguageAreadyExists()
    {
        $languageId = request()->input('language_id');
        $notDefaultLang = $this->pageToBeCopiedIsNotInDefaultLanguage();

        $pageId = $this->route('page_id');

        $exists = DB::table('dvs_pages')
            ->where('language_id', $languageId)
            ->where(function ($query) use ($pageId, $notDefaultLang) {
                if ($notDefaultLang)
                {
                    $query->where('translated_from_page_id', $pageId);
                } else
                {
                    $query->orWhere('translated_from_page_id', 0);
                }
            })->first();

        return $exists;
    }

    public function pageToBeCopiedIsNotInDefaultLanguage()
    {
        $pageId = $this->route('page_id');

        $page = DB::table('dvs_pages')
            ->select('language_id')
            ->find($pageId);

        $site = $this->SiteDetector->current();

        return ($site->default_language->id != $page->language_id);
    }
}
