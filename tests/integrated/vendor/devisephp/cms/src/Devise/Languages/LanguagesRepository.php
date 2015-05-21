<?php namespace Devise\Languages;

use DvsLanguage, DvsPage, DvsPageVersion;
use Devise\Languages\LanguageDetector as Detector;

/**
 * The langauges repository provides methods to
 * fetch rows in the context of DvsLanguage model
 */
class LanguagesRepository
{
    /**
     * [$Language description]
     * @var [type]
     */
    protected $Language, $Detector, $Page;

    /**
     * Construct language repository
     *
     * @param DvsLanguage $Language
     * @param Detector $Detector
     * @param DvsPage $Page
     * @param DvsPageVersion $PageVersion
     */
    public function __construct(DvsLanguage $Language, Detector $Detector, DvsPage $Page, DvsPageVersion $PageVersion)
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
     * @param $page
     * @return
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
     * Finds the language for a given page version
     *
     * @param  int $pageVersionId
     * @return Language
     */
    public function findLanguageForPageVersion($pageVersionId)
    {
        $pageVersion = $this->PageVersion->findOrFail($pageVersionId);

        return $pageVersion->page->language;
    }

}