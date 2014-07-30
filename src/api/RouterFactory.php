<?php

namespace UniMapper\Nette\Api;

use Nette\Application\Routers\RouteList,
    Nette\Application\IRouter,
    Nette\Utils\Strings,
    Nette\Application\Routers\Route;

class RouterFactory
{

    public static function prependTo(IRouter &$router, $module)
    {
        if (!$router instanceof RouteList) {
            throw new \Exception(
                'Router must be an instance of Nette\Application\Routers\RouteList'
            );
        }

        $apiRouter = new RouteList($module);
        $apiRouter[] = new Route(Strings::webalize($module) . "/<presenter>[/<id>]");
        $router[] = $apiRouter; // need to increase the array size

        $lastKey = count($router) - 1;
        foreach ($router as $i => $route) {

            if ($i === $lastKey) {
                break;
            }
            $router[$i + 1] = $route;
        }

        $router[0] = $apiRouter;
    }

}