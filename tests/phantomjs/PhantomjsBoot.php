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

use Codeception\Exception\Extension as ExtensionException;

class PhantomjsBoot extends \Codeception\Platform\Extension
{

    // list events to listen to
    static $events = array(
        'suite.before' => 'beforeSuite',
    );

    private $resource;

    private $pipes;

    public static $includeInheritedActions = false;

    public static $onlyActions = array();
    public static $excludeActions = array();

    public function __construct($config, $options = array())
    {
        $options['silent'] = false;
        parent::__construct($config, $options);

        // Set default path for PhantomJS to "vendor/bin/phantomjs" for if it was installed via composer
        if (!isset($this->config['path'])) {
            $this->config['path'] = "vendor/bin/phantomjs";
        }

        // If a directory was provided for the path, use old method of appending PhantomJS
        if (is_dir(realpath($this->config['path']))) {
            // Show warning that this is being deprecated
            $this->writeln("\r\n");
            $this->writeln("WARNING: The PhantomJS path for Phantoman is set to a directory, this is being deprecated in the future. Please update your Phantoman configuration to be the full path to PhantomJS.");

            $this->config['path'] .= '/phantomjs';
        }

        // Add .exe extension if running on the windows
        if ($this->isWindows() && file_exists(realpath($this->config['path'] . '.exe'))) {
            $this->config['path'] .= '.exe';
        }

        // Set default WebDriver port
        if (!isset($this->config['port'])) {
            $this->config['port'] = 4444;
        }
    }

    /**
     * Start PhantomJS server
     */
    private function startServer()
    {
        $this->writeln("\r\n");
        $this->writeln("Starting PhantomJS Server");

        $command = $this->getCommand();

        $descriptorSpec = array(
            array('pipe', 'r'),
            array('file', $this->getLogDir() . 'phantomjs.output.txt', 'w'),
            array('file', $this->getLogDir() . 'phantomjs.errors.txt', 'a')
        );

        $this->resource = proc_open($command, $descriptorSpec, $this->pipes, null, null, array('bypass_shell' => true));

        if (!is_resource($this->resource) || !proc_get_status($this->resource)['running']) {
            proc_close($this->resource);
            throw new ExtensionException($this, 'Failed to start PhantomJS server.');
        }

        // Wait till the server is reachable before continuing
        $max_checks = 10;
        $checks = 0;

        $this->write("Waiting for the PhantomJS server to be reachable");
        while (true) {
            if ($checks >= $max_checks) {
                throw new ExtensionException($this, 'PhantomJS server never became reachable');
                break;
            }

            if ($fp = @fsockopen('127.0.0.1', $this->config['port'], $errCode, $errStr, 10)) {
                $this->writeln('');
                $this->writeln("PhantomJS server now accessible");
                fclose($fp);
                break;
            }

            $this->write('.');
            $checks++;

            // Wait before checking again
            sleep(1);
        }

        // Clear progress line writing
        $this->writeln('');
    }

    /**
     * Stop PhantomJS server
     */
    private function stopServer()
    {
        if ($this->resource !== null) {
            $this->write("Stopping PhantomJS Server");

            // Wait till the server has been stopped
            $max_checks = 10;
            for ($i = 0; $i < $max_checks; $i++) {
                // If we're on the last loop, and it's still not shut down, just
                // unset resource to allow the tests to finish
                if ($i == $max_checks - 1 && proc_get_status($this->resource)['running'] == true) {
                    $this->writeln('');
                    $this->writeln("Unable to properly shutdown PhantomJS server");
                    unset($this->resource);
                    break;
                }

                // Check if the process has stopped yet
                if (proc_get_status($this->resource)['running'] == false) {
                    $this->writeln('');
                    $this->writeln("PhantomJS server stopped");
                    unset($this->resource);
                    break;
                }

                foreach ($this->pipes as $pipe) {
                    fclose($pipe);
                }
                proc_terminate($this->resource, 2);

                $this->write('.');

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

    /**
     * Checks if the current machine is Windows.
     *
     * @return bool True if the machine is windows.
     * @see http://stackoverflow.com/questions/5879043/php-script-detect-whether-running-under-linux-or-windows
     */
    private function isWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    ///////
    // required methods
    ///////

    public function _resetConfig() {}

    public function _getName() {}

    ///////
    // required methods that handle events
    ///////

    // // HOOK: on every Actor class initialization
    public function _cleanup() {}

    // HOOK: before each suite
    public function _beforeSuite($settings = array()) {}

    // // HOOK: after suite
    public function _afterSuite() {}

    // // HOOK: before each step
    public function _beforeStep(\Codeception\Step $step) {}

    // // HOOK: after each step
    public function _afterStep(\Codeception\Step $step) {}

    // // HOOK: before test
    public function _before(\Codeception\TestCase $test) {
        $this->startServer();
    }

    // // HOOK: after test
    public function _after(\Codeception\TestCase $test) {
        $this->stopServer();
    }

    // // HOOK: on fail
    public function _failed(\Codeception\TestCase $test, $fail) {}
}
