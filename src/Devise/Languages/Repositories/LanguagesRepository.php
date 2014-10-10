<?php namespace Devise\Languages\Repositories;

use Language;
use Page;
use PageVersion;
use Devise\Languages\LanguageDetector as Detector;

class LanguagesRepository
{
    protected $Language, $Detector, $Page;

    public function __construct(Language $Language, Detector $Detector, Page $Page, PageVersion $PageVersion)
    {
        $this->Language = $Language;
        $this->Detector = $Detector;
        $this->Page = $Page;
        $this->PageVersion = $PageVersion;
    }

    /**
     * Paginated list of languages
     *
     * @return Eloquent\Collection
     */
    public function languages()
    {
        return $this->Language->paginate(250);
    }

    /**
     * List of active languages
     *
     */
    public function activeLanguageList()
    {
        return $this->Language->where('active', '=', 1)->orderby('updated_at')->lists('human_name', 'id');
    }

    /**
     * List of options for the a language selector
     */
    public function languageSelectorOptions($page)
    {
        $pageId = $page->translated_from_page_id == 0 ? $page->id : $page->translated_from_page_id;

        // get the languages available for this specific pageId
        $languages = $this->Language->join('dvs_pages', 'dvs_pages.language_id', '=', 'dvs_languages.id')
            ->where(function($query) use ($pageId){
                $query->orWhere('dvs_pages.translated_from_page_id', '=', $pageId)
                      ->orWhere('dvs_pages.id', '=', $pageId);
            })
            ->groupBy('dvs_pages.language_id')
            ->orderBy('dvs_pages.language_id')
            ->get(['dvs_languages.*','dvs_pages.slug']);

        return $languages->lists('name', 'slug');
    }

    /**
     * Magical method that gets the language for
     * the current request and user
     *
     * @return Language
     */
    public function currentLanguage()
    {
        return $this->Detector->current();
    }

    /**
     * [findLanguageForPageVersion description]
     * @param  [type] $pageVersionId [description]
     * @return [type]                [description]
     */
    public function findLanguageForPageVersion($pageVersionId)
    {
        $pageVersion = $this->PageVersion->findOrFail($pageVersionId);

        return $pageVersion->page->language;
    }

}