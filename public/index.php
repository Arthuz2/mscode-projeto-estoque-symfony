<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';
session_start();
date_default_timezone_set('America/Sao_Paulo');
return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
