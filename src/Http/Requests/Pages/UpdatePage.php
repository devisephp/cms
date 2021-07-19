<?php

namespace Devise\Http\Requests\Pages;

use Devise\Http\Rules\ViewExists;
use Devise\Http\Requests\ApiRequest;
use Devise\Sites\SiteDetector;
use Illuminate\Validation\Rule;

class UpdatePage extends ApiRequest
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
    $pageId = $this->route('page_id');

    return [
      'title'              => 'filled',
      'slug'               => [
        'filled',
        Rule::unique('dvs_pages')->where(function ($query) use ($site, $pageId) {
          return $query->where('site_id', $site->id)
            ->where('id', '!=', $pageId)
            ->whereNull('deleted_at');
        })
      ],
      'ab_testing_enabled' => 'filled|boolean'
    ];
  }
}
