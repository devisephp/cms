<?php
namespace Devise\Meta;

use Illuminate\Support\Facades\Input;

class Response
{
  /**
   * @var MetaRepository
   */
  private $Repository;

  /**
   * @var MetaManager
   */
  private $Manager;

  /**
   * Response constructor.
   * @param MetaRepository $MetaRepository
   */
  public function __construct(MetaRepository $MetaRepository, MetaManager $MetaManager)
  {
    $this->Repository = $MetaRepository;
    $this->Manager = $MetaManager;
  }

  public function getGlobal()
  {
    return $this->Repository->globalMeta();
  }

  public function getPage($pageId)
  {
    return $this->Repository->pageMeta($pageId);
  }

  public function requestCreate($input)
  {
    $create = $this->Manager->createMeta($input);
    if ($create) {
      return $create;
    }
    return \Response::json('There was an error', 400);
  }

  public function requestUpdate($input)
  {
    $update = $this->Manager->updateMeta($input);
    if ($update) {
      return $update;
    }
    return \Response::json('There was an error', 400);
  }

  public function requestDelete($metaId)
  {
    return $this->Manager->deleteMeta($metaId);
  }
}
