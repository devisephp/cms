<?php namespace Devise\Installer;

class InstallerResponseHandler
{
    protected $InstallerManager;

    public function __construct(InstallerManager $InstallerManager)
    {
        $this->InstallerManager = $InstallerManager;
    }

    public function executeInstall($input)
    {
        if($this->InstallerManager->attemptInstall($input)) {
            re
        }
    }
}