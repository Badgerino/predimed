<?php
declare(strict_types=1);

defined('FCPATH') || define('FCPATH', realpath(__DIR__) . DIRECTORY_SEPARATOR);

use CodeIgniter\Boot;
use Config\Paths;

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require __DIR__ . '/../app/Config/Paths.php';
$paths = new Paths();

require $paths->systemDirectory . '/Boot.php';

// Boot the framework for web requests
Boot::bootWeb($paths);