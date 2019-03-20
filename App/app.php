<?php
session_start();

define('ENVIRONMENT', 'development');
defined('APP_NAME') || define('APP_NAME', 'Developers & Skills');
defined('ENVIRONMENT') || define('ENVIRONMENT', 'development');

if(ENVIRONMENT == 'production') {
    error_reporting(0);
    ini_set('display_errors', 0);
} else if (ENVIRONMENT == 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

require_once dirname(__FILE__).'/../vendor/autoload.php';

use App\Database\DB;
use App\Database\Data;
use App\Helpers\Functions;

if(!isset($_SESSION['token']) || (isset($_SESSION['token']) && Functions::tokenExpired($_SESSION['token'], 7200)) ) {
    $_SESSION['token'] = [
        'value' => Functions::createToken(),
        'created_at' => time(),
    ];
}

$db_data = new Data(DB::getInstance());

$developers = $db_data->getDevelopersList();
$skills = $db_data->getSkillsList();

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
    if (isset($_POST['q'])) {
        $params = Functions::parseParams($_POST['q']);
        $data = $db_data->filterSQLQuery($params);
        $results_by = array_pop($data);
        include dirname(__FILE__) . '/Views/table.php';
        exit();
    }
}

if (isset($_GET['q'])) {
    $params = Functions::parseParams($_GET['q']);
    $data = $db_data->filterSQLQuery($params);
} else {
    $data = $db_data->pageInit();
}

$results_by = array_pop($data);
