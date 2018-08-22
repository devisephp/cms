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
    $site = $this->SiteDetector->current();

    return [
      'title' => 'required|min:3',
      'layout' => 'required|min:3',
      'slug'  => [
        'required',
        Rule::unique('dvs_pages')->where(function ($query) use ($site) {
          return $query->where('site_id', $site->id)
            ->whereNull('deleted_at');
        })
      ]
    ];
  }
}
