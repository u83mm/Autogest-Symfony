<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';
require_once dirname(__DIR__).'/clean_logs/clean_xdebug_log.php';
require_once dirname(__DIR__).'/clean_logs/clean_access_log.php';
require_once dirname(__DIR__).'/clean_logs/clean_error_log.php';
require_once dirname(__DIR__).'/clean_logs/clean_dev_log.php';
	

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
