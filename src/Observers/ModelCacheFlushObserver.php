<?php

namespace Devise\Observers;


use Devise\Models\DvsPage;
use Illuminate\Support\Facades\Cache;

class ModelCacheFlushObserver
{
    /**
     *
     */
    public function saved($model)
    {
        if ($model instanceof DvsPage)
        {
            Cache::forget('devise.page.' . $model->route_name . '.' . $model->site_id);
        } else
        {
            Cache::flush();
        }
    }
}
