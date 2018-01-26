<?php

namespace App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Log\LogServiceProvider;
use Illuminate\Log\Writer;

/**
 * Class SplitLogServiceProvider
 * @package App\Providers
 *
 * @property Application app
 */
class SplitLogServiceProvider extends LogServiceProvider
{
    const DEFAULT_LOG_FILENAME_PREFIX = 'laravel';

    /**
     * @inheritDoc
     */
    protected function configureSingleHandler(Writer $log)
    {
        $log->useFiles(
            $this->app->storagePath().'/logs/'.$this->getLogFilename(),
            $this->logLevel()
        );
    }

    /**
     * @inheritDoc
     */
    protected function configureDailyHandler(Writer $log)
    {
        $log->useDailyFiles(
            $this->app->storagePath().'/logs/'.$this->getLogFilename(), $this->maxFiles(),
            $this->logLevel()
        );
    }

    protected function getLogFilename()
    {
        return $this->getLogFilenamePrefix().'-'.php_sapi_name().'.log';
    }

    protected function getLogFilenamePrefix()
    {
        if ($this->app->bound('config')) {
            return $this->app->make('config')->get('app.log_filename_prefix', static::DEFAULT_LOG_FILENAME_PREFIX);
        }

        return static::DEFAULT_LOG_FILENAME_PREFIX;
    }
}
