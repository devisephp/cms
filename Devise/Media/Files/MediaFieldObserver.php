<?php


namespace Devise\Media\Files;

use Devise\Sites\SiteDetector;
use DvsMediaManager;
use Illuminate\Support\Facades\Log;

class MediaFieldObserver
{
    /**
     * @var Repository
     */
    private $repository;
    /**
     * @var SiteDetector
     */
    private $SiteDetector;

    /**
     * MediaFieldObserver constructor.
     */
    public function __construct(Repository $repository, SiteDetector $SiteDetector)
    {
        $this->repository = $repository;
        $this->SiteDetector = $SiteDetector;
    }

    public function saved($model)
    {
        $this->updateMediaManager($model, 1);
    }

    public function deleted($model)
    {
        $this->updateMediaManager($model, -1);
    }

    private function updateMediaManager($model, $direction = 1)
    {
        if ($model->type == 'image' || $model->type == 'file')
        {
            list($path, $fileName) = $this->getNameAndPath($model);

            $site = $this->SiteDetector->current();

            $record = $site->media()->where('directory', $path)
                ->where('name', $fileName)
                ->first();

            if ($record && $record->getDirty())
            {
                $record += $direction;
                $record->save();
            }
        }
    }

    private function getNameAndPath($model)
    {
        $val = json_decode($model->json_value);

        if (isset($val->image))
        {
            $imagePath = $val->image;
            $parts = explode('/', $imagePath);
            $fileName = array_pop($parts);
            array_shift($parts);
            $path = implode("/", $parts);

            return [$path, $fileName];
        }

        return ['', ''];
    }

    private function isGlobal($model)
    {
        return (strpos(get_class($model), 'DvsGlobalField') !== false);
    }
}
