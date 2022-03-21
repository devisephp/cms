<?php

namespace Devise\Console\Commands;

use Devise\Devise;
use Devise\Models\DvsPage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Spatie\Browsershot\Browsershot;
use Spatie\Image\Manipulations;

class GenerateSliceThumbnails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'devise:generate-slice-thumbs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates thumbnails for all slices that have not been captured.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $allSlices = File::allFiles(resource_path('views/slices'));
        shuffle($allSlices);

        foreach ($allSlices as $slice) {
            $name = $this->getClassFromPath($slice->getPathName());
            if ($this->sliceNeedsThumbnail($name)) {
                $view = $this->getViewFromPath($slice->getPathName());
                $url = $this->findURL($view);
                if ($url) {
                    $this->capture($url, $name);
                    break;
                }
            }
        }
    }

    protected function capture($url, $name)
    {
        $savePath = storage_path() . '/app/public/slice-previews/' . $name . '.png';
        $url .= '?slice_capture=' . $name;

        Browsershot::url($url)
            ->select('.' . $name, 0)
            ->windowSize(1024, 768)
            ->fit(Manipulations::FIT_CONTAIN, 500, 500)
            ->save($savePath);

        $this->moveToCloudIfNecessary($savePath, $name . '.png');
    }

    protected function getViewFromPath($path)
    {
        $name = trim(str_replace(resource_path(), '', $path), '/');
        $name = str_replace('.blade.php', '', $name);
        $name = str_replace('/', '.', $name);
        $name = str_replace('views.', '', $name);

        return $name;
    }

    protected function getClassFromPath($path)
    {
        $name = trim(str_replace(resource_path(), '', $path), '/');
        $name = str_replace('.blade.php', '', $name);
        $name = preg_replace("/[^a-zA-Z]/", " ", $name);
        $name = str_replace('views slices', 'devise', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);

        return $name;
    }

    protected function findURL($view)
    {
        $pageVersionIds = DB::table('dvs_slice_instances')
            ->where('dvs_slice_instances.view', $view)
            ->pluck('dvs_slice_instances.page_version_id')
            ->toArray();

        $pages = DvsPage::select('dvs_pages.*')
            ->with('currentVersion')
            ->join('dvs_page_versions', 'dvs_page_versions.page_id', '=', 'dvs_pages.id')
            ->whereIn('dvs_page_versions.id', $pageVersionIds)
            ->inRandomOrder()
            ->get();

        foreach ($pages as $page) {
            if (in_array($page->currentVersion->id, $pageVersionIds) && $page->permalink != '#') {
                return $page->permalink;
            }
        }

        return null;
    }

    protected function sliceNeedsThumbnail($name)
    {
        return !File::exists(storage_path() . '/app/public/slice-previews/' . $name . '.png');
    }

    protected function moveToCloudIfNecessary($savePath, $fileName)
    {
        if (config('devise.media.disk') == 's3' || config('devise.media.disk') == 'spaces') {
            $image = File::get($savePath);
            Storage::disk(config('devise.media.disk'))->put('/slice-previews/' . $fileName, $image, ['visibility' => 'public']);
        }
    }
}
