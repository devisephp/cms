<?php

namespace Devise\Console\Commands;

use App\User;
use Devise\Models\DvsLanguage;
use Devise\Models\DvsSite;
use Devise\Support\Framework;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Mockery\Exception;

class CleanStyledMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'devise:clean-styled-media {--dry-run : Will not delete files. Will only print summary.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes styled media that is no longer being used';

    private $deleteCount = 0;

    private $Storage = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');

        $allFiles = $this->getAllStyled();

        foreach ($allFiles as $filePath)
        {
            if ($this->isOrphaned($filePath))
                $this->delete($filePath, $dryRun);
        }

        $this->echoSummary(count($allFiles), $dryRun);
    }

    private function getAllStyled()
    {
        $Storage = $this->getStorage();

        return $Storage->allFiles(config('devise.media.cached-images-directory'));
    }

    private function isOrphaned($path)
    {
        $ignore = ['.DS_Store'];
        $fileName = basename($path);
        if (!in_array($fileName, $ignore) && $this->isNotUsedInFields($path))
            return true;

        return false;
    }

    private function isNotUsedInFields($path)
    {
        $escapedPath = str_replace('/', '\\\\\/', $path);
        $found = DB::table('dvs_fields')
            ->where('json_value', 'like', '%' . $escapedPath . '%')
            ->select('id')
            ->get();

        return $found->count() === 0;
    }

    private function delete($styledPath, $dryRun = true)
    {
        $this->line('delete ' . $styledPath);
        if (!$dryRun)
        {
            $Storage = $this->getStorage();
            $Storage->delete($styledPath);
        }
        $this->deleteCount++;
    }

    private function echoSummary($allCount, $dryRun = true)
    {
        $willBe = ($dryRun) ? ' will be' : '';
        $this->line($allCount . ' files found');
        $this->line($this->deleteCount . $willBe . ' deleted');

        $pct = number_format(100 * ($this->deleteCount / $allCount), 2);
        $msg = number_format(100 * ($this->deleteCount / $allCount), 2) . '% of styled files' . $willBe . ' deleted';

        if ($pct > 50)
            $this->error($msg);
        else
            $this->line($msg);
    }

    private function getStorage()
    {
        if ($this->Storage) return $this->Storage;

        $Framework = App::make(Framework::class);

        return $Framework->storage->disk(config('devise.media.disk'));
    }
}
