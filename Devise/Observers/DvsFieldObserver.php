<?php

namespace Devise\Observers;


use Devise\Models\DvsField;
use Illuminate\Support\Facades\URL;

class DvsFieldObserver
{
    /**
     * Handle the dvs field "creating" event.
     *
     * @param  DvsField $dvsField
     * @return void
     */
    public function saving(DvsField $dvsField)
    {
        $this->replaceAbsoluteImagesWithRelative($dvsField);
    }

    private function replaceAbsoluteImagesWithRelative(DvsField $dvsField)
    {
        $valueObject = json_decode($dvsField->json_value);

        if ($valueObject && isset($valueObject->text))
        {
            $html = $valueObject->text;
            preg_match_all('@src="([^"]+)"@', $html, $match);

            $imgSrcs = array_pop($match);
            $urlToReplace = URL::to('/') . '/storage';

            foreach ($imgSrcs as $imgSrc)
            {
                if (strpos($imgSrc, $urlToReplace) === 0)
                {
                    $newImgSrc = str_replace($urlToReplace, '/storage', $imgSrc);
                    $html = str_replace('src="' . $imgSrc, 'src="' . $newImgSrc, $html);
                }
            }

            $valueObject->text = $html;

            $dvsField->json_value = json_encode($valueObject);
        }
    }
}
