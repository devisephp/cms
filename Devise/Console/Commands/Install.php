<?php

namespace Devise\Console\Commands;

use App\User;
use Devise\Models\DvsLanguage;
use Devise\Models\DvsSite;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Mockery\Exception;

class Install extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'devise:install';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Devise Install Wizard';

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
    $dbExists = $this->checkDatabaseExists();

    if ($dbExists)
    {
      $this->handleMigrations();
      $this->handlePublishing();
      $this->handleDefaultLanguage();
      $this->handleSiteEntry();
      $this->handleSlicesDirectory();

      $this->handleUser();

      $overwrite = $this->handleEnvironmentalSiteOverwrites();

      $this->handleWelcome($overwrite);
    }
  }

  private function checkDatabaseExists()
  {
    try
    {
      // test statement will cause error if database connection not working
      DB::statement('select 1 from dual');

      $dbName = DB::connection()->getDatabaseName();

      $this->info("Database [$dbName] found.");

      return true;

    } catch (\Exception $e)
    {
      $this->error('Database connection not working. Please connect your project to a database.');

      return false;
    }
  }

  private function handleMigrations()
  {
    $this->call('migrate');
  }

  private function handlePublishing()
  {
    $this->call('vendor:publish', ['--tag' => 'dvs-assets']);
    $this->call('vendor:publish', ['--tag' => 'dvs-config']);
  }

  private function handleDefaultLanguage()
  {
    $languageCount = DvsLanguage::count();

    if ($languageCount) 
    {
      $this->info('Language entries found. No configuration necessary.');
    } else 
    {
      DvsLanguage::create([
        'code'     => 'en',
        'created_at'    => Date('Y-m-d H:i:s'),
        'updated_at'    => Date('Y-m-d H:i:s') 
      ]);
    }
  }

  private function handleSiteEntry()
  {
    $siteCount = DvsSite::count();

    if ($siteCount)
    {
      $this->info('Site entries found. No configuration necessary.');
    } else
    {
      $siteName = $this->ask('Please input the name of your production site.');
      $siteDomain = $this->ask('Please input the domain of your production site.');

      $site = DvsSite::create([
        'name'     => $siteName,
        'domain'   => $siteDomain,
        'settings' => '{}',
        'created_at'    => Date('Y-m-d H:i:s'),
        'updated_at'    => Date('Y-m-d H:i:s') 
      ]);

      DB::table('dvs_site_element')->insert([
        'site_id'       => $site->id,
        'element_type'  => 'Devise\Models\DvsLanguage',
        'element_id'    => 1,
        'default'       => 1,
        'created_at'    => Date('Y-m-d H:i:s'),
        'updated_at'    => Date('Y-m-d H:i:s') 
      ]);

      $this->info("$siteName [$siteDomain] has been created.");
    }
  }

  private function handleEnvironmentalSiteOverwrites()
  {
    $appEnv = App::environment();
    $currentLocalDomain = env("SITE_1_DOMAIN", false);

    if ($appEnv !== 'production')
    {
      if (!$currentLocalDomain) {
        $localDomain = $this->ask('Not in production? Enter a domain for your ' . $appEnv . ' site.');

        if ($localDomain)
        {
          $this->setEnvironmentValue('SITE_1_DOMAIN', $localDomain);

          return $localDomain;
        }
      } else {
        return $currentLocalDomain;
      }
    }
  }

  private function handleUser()
  {
    $userCount = User::count();

    if ($userCount)
    {
      $this->info('Users found. No configuration necessary.');
    } else
    {
      $name = $this->ask('What is the name of your administrator?');
      $email = $this->ask('What is the email of your administrator?');
      $password = $this->ask('What is the password of your administrator?');

      User::create([
        'name'     => $name,
        'email'    => $email,
        'password' => Hash::make($password),
        'created_at'    => Date('Y-m-d H:i:s'),
        'updated_at'    => Date('Y-m-d H:i:s') 
      ]);

      $this->info("The account for $name [$email] has been created.");
    }
  }

  private function handleSlicesDirectory()
  {
    $slicesDirectory = resource_path('views/slices');
    if(!is_dir($slicesDirectory))
    {
      File::makeDirectory($slicesDirectory);

      $this->info("The /resources/views/slices directory has been created.");
    }
  }

  private function handleWelcome($overwrite)
  {
    $this->info('Welcome to Devise!');

    $site = DvsSite::orderBy('id', 'asc')->first();

    $domain = $overwrite ?: $site->domain;

    $url = 'http://' . $domain . '/devise';

    shell_exec('open ' . $url);
  }

  private function setEnvironmentValue($envKey, $envValue)
  {
    $envFile = app()->environmentFilePath();
    $str = file_get_contents($envFile);

    $oldValue = env($envKey);

    if ($oldValue)
    {
      $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}\n", $str);
    } else
    {
      $str .= "\n{$envKey}={$envValue}";
    }

    $fp = fopen($envFile, 'w');
    fwrite($fp, $str);
    fclose($fp);
  }
}
