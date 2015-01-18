<?php
require_once '../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use TestPyrite\Container\DICITAdapter;
use Pyrite\Routing\Director as RouterDirector;
use Pyrite\Routing\RouteConfigurationBuilderI18n;
use Pyrite\Routing\RouteConfigurationBuilderImpl;
use Pyrite\Kernel\PyriteKernel as PyriteKernel;
use DICIT\Config\YML;
use DICIT\ActivatorFactory;


date_default_timezone_set('Europe/Paris');

function ddie($a)
{
    var_dump($a);
    try {
        throw new Exception("Error Processing Request", 1);
    }
    catch(Exception $e) {
        echo $e->getTraceAsString();
        die("la");
    }
}

$routingPath = '../config/routes.yml';
$containerPath = '../config/container.yml';

//
//

$cfgYML = new \DICIT\Config\YML($containerPath);
$container = new \DICIT\Container($cfgYML);
// var_dump($container->get('PyriteSessionFactory'));

// die();
//
//

$request = Request::createFromGlobals();


$config = new YML($containerPath);
$activator = new ActivatorFactory();
$container = new DICITAdapter($config, $activator);

$host = $request->getHttpHost();
$locale = $container->getParameter('default_locale.' . str_replace('.', '_', $host));
if ($locale === null) {
    $locale = $container->getParameter('default_locale.default');
}
$container->setParameter('current_locale', $locale);


try {
    $routerDirector = new RouterDirector($request, $routingPath);
    $routerBuilder = new RouteConfigurationBuilderI18n($container->getParameter('current_locale') , $container->getParameter('default_locale.all'));
    $routeConfiguration = $routerDirector->build($routerBuilder);
    $container->bind('UrlGenerator', $routeConfiguration->getUrlGenerator());
}
catch(\Exception $e) {
    var_dump($e);
    trigger_error($e->getMessage() , E_USER_ERROR);
    exit(1);
}


PyriteKernel::boot($request, $routeConfiguration->getRouteCollection() , $container);

