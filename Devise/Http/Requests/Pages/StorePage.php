<?php

namespace Devise\Http\Requests\Pages;

use Devise\Http\Requests\ApiRequest;
use Devise\Sites\SiteDetector;
use Illuminate\Validation\Rule;

class StorePage extends ApiRequest
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
        $siteId = $this->getSiteId();

        if (!$siteId) {
            return false;
        }

        return [
            'title'        => 'required|min:3',
            'layout'       => 'required_if:copy_page_id,0',
            'copy_page_id' => 'required_if:layout,null',
            'slug'         => [
                'required',
                Rule::unique('dvs_pages')->where(function ($query) use ($siteId) {
                    return $query->where('site_id', $siteId)
                        ->whereNull('deleted_at');
                })
            ]
        ];
    }

    private function getSiteId() {
        $site = $this->SiteDetector->current();

        if ($site) {
            return $site->id;
        }
 
        if (!$site && $this->content) {
            $requestData = json_decode($this->content);
            if ($requestData && $requestData->site_id) {
                return $requestData->site_id;
            }
        }

        return false;
    }
}
