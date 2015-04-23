<?php
/**
 * Phantoman
 *
 * The Codeception extension for automatically starting and stopping PhantomJS
 * when running tests.
 *
 * Originally based off of PhpBuiltinServer Codeception extension
 * https://github.com/tiger-seo/PhpBuiltinServer
 */

namespace LBM;

use Codeception\Configuration as Config;
use Codeception\Exception\Extension as ExtensionException;
use Codeception\Lib\Console\Output;

class PhantomjsBoot extends \Codeception\Module
{
    private $resource;

    private $pipes;

    private $output;

    private $logDir;

    public function __construct($config)
    {
        parent::__construct($config);

        $this->output = new Output([]);
        $this->logDir = Config::outputDir();

        // Set default path for PhantomJS to "vendor/bin/phantomjs" for if it was installed via composer
        if (!isset($this->config['path'])) {
            $this->config['path'] = "vendor/bin/phantomjs";
        }

        // If a directory was provided for the path, use old method of appending PhantomJS
        if (is_dir(realpath($this->config['path']))) {
            // Show warning that this is being deprecated
            $this->output->writeln("\r\n");
            $this->output->writeln("WARNING: The PhantomJS path for Phantoman is set to a directory, this is being deprecated in the future. Please update your Phantoman configuration to be the full path to PhantomJS.");

            $this->config['path'] .= '/phantomjs';
        }

        // Set default WebDriver port
        if (!isset($this->config['port'])) {
            $this->config['port'] = 4444;
        }

        $this->startServer();
        $resource = $this->resource;
        register_shutdown_function(
            function () use ($resource) {
                if (is_resource($resource)) {
                    proc_terminate($resource);
                }
            }
        );
    }
    public function __destruct()
    {
        $this->stopServer();
    }

    /**
     * Start PhantomJS server
     */
    private function startServer()
    {
        $this->output->writeln("\r\n");
        $this->output->writeln("Starting PhantomJS Server");

        $command = $this->getCommand();

        $descriptorSpec = array(
            array('pipe', 'r'),
            array('file', $this->logDir . 'phantomjs.output.txt', 'w'),
            array('file', $this->logDir . 'phantomjs.errors.txt', 'a')
        );

        $this->resource = proc_open($command, $descriptorSpec, $this->pipes, null, null, array('bypass_shell' => true));

        if (!is_resource($this->resource) || !proc_get_status($this->resource)['running']) {
            proc_close($this->resource);
            throw new ExtensionException($this, 'Failed to start PhantomJS server.');
        }

        // Wait till the server is reachable before continuing
        $max_checks = 10;
        $checks = 0;

        $this->output->writeln("Waiting for the PhantomJS server to be reachable");
        while (true) {
            if ($checks >= $max_checks) {
                throw new ExtensionException($this, 'PhantomJS server never became reachable');
                break;
            }

            if ($fp = @fsockopen('127.0.0.1', $this->config['port'], $errCode, $errStr, 10)) {
                $this->output->writeln('');
                $this->output->writeln("PhantomJS server now accessible");
                fclose($fp);
                break;
            }

            $this->output->writeln('.');
            $checks++;

            // Wait before checking again
            sleep(1);
        }

        // Clear progress line writing
        $this->output->writeln('');
    }

    /**
     * Stop PhantomJS server
     */
    private function stopServer()
    {
        if ($this->resource !== null) {
            $this->output->writeln("Stopping PhantomJS Server");

            // Wait till the server has been stopped
            $max_checks = 10;
            for ($i = 0; $i < $max_checks; $i++) {
                // If we're on the last loop, and it's still not shut down, just
                // unset resource to allow the tests to finish
                if ($i == $max_checks - 1 && proc_get_status($this->resource)['running'] == true) {
                    $this->output->writeln('');
                    $this->output->writeln("Unable to properly shutdown PhantomJS server");
                    unset($this->resource);
                    break;
                }

                // Check if the process has stopped yet
                if (proc_get_status($this->resource)['running'] == false) {
                    $this->output->writeln('');
                    $this->output->writeln("PhantomJS server stopped");
                    unset($this->resource);
                    break;
                }

                foreach ($this->pipes as $pipe) {
                    fclose($pipe);
                }
                proc_terminate($this->resource, 2);

                $this->output->writeln('.');

                // Wait before checking again
                sleep(1);
            }
        }
    }

    /**
     * getCommandParameters
     *
     * @return string
     */
    private function getCommandParameters()
    {
        $mapping = array(
            'proxy' => '--proxy',
            'proxyType' => '--proxy-type',
            'proxyAuth' => '--proxy-auth',
            'webSecurity' => '--web-security',
            'port' => '--webdriver',
        );
        $params = array();
        foreach ($this->config as $configKey => $configValue) {
            if (!empty($mapping[$configKey])) {
                $params[] = $mapping[$configKey] . '=' . $configValue;
            }
        }
        return implode(' ', $params);
    }

    /**
     * Get PhantomJS command
     */
    private function getCommand()
    {
        return escapeshellarg(realpath($this->config['path'])) . ' ' . $this->getCommandParameters();
    }
}
