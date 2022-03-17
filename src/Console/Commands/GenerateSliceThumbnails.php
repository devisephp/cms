<?php

namespace Devise\Console\Commands;

use Devise\Devise;
use Devise\Models\DvsPage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

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
        foreach ($allSlices as $slice) {
            $class = $this->getClassFromPath($slice->getPathName());
            $view = $this->getViewFromPath($slice->getPathName());
            $url = $this->findURL($view);

            $this->capture($url, $class, $view);

            break;
        }
    }

    protected function capture($url, $class, $fileName)
    {
        $savePath = storage_path() . '/app/public/slice-previews/' . $fileName . '.png';

        Browsershot::url($url)
            ->select($class, 0)
            ->windowSize(1024, 768)
            ->fit(Manipulations::FIT_CONTAIN, 500, 500)
            ->save($savePath);
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
        $now = Devise::currentDateTime();

        $page = DvsPage::select('dvs_pages.*')
            ->join('dvs_page_versions', 'dvs_page_versions.page_id', '=', 'dvs_pages.id')
            ->join('dvs_slice_instances', 'dvs_slice_instances.page_version_id', '=', 'dvs_page_versions.id')
            ->where('dvs_slice_instances.view', $view)
            ->where('dvs_page_versions.starts_at', '<=', $now)
            ->where(
                function ($query) use ($now) {
                    $query->where('dvs_page_versions.ends_at', '>', $now);
                    $query->orWhereNull('dvs_page_versions.ends_at');
                }
            )
            ->orderBy('dvs_page_versions.starts_at', 'DESC')
            ->first();

        return $page && $page->permalink != '#' ? $page->permalink : null;
    }
}
