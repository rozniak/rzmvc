<?php

/**
 * WebRouter.php - rzmvc Web Router
 *
 * This source-code is part of the rzmvc project by Oddmatics:
 * <<https://www.oddmatics.uk>>
 *
 * Author(s): Rory Fewell <roryf@oddmatics.uk>
 */

namespace Rzmvc\Mvc;


/**
 * Routes web requests to target controller actions.
 */
final class WebRouter
{
    /**
     * The root directory of the website to route.
     *
     * @var string
     */
    private $webRootDir;


    /**
     * Initializes a new instance of the WebRouter class.
     *
     * @param string $root
     *     The root directory of the website to route.
     */
    public function __construct(
        string $root
    )
    {
        $this->webRootDir = $root;
    }


    /**
     * Routes the request.
     *
     * @param string $uri
     *     The URI to route.
     */
    public function route(
        string $uri
    )
    {
        $controllerAction = $this->getControllerAction($uri);

        $this->runAction($controllerAction);
    }


    /**
     * Gets the controller action for the URI.
     *
     * @param string $uri
     *     The URI.
     */
    private function getControllerAction(
        string $uri
    )
    {
        $segments     = explode('/', $uri);
        $segmentCount = count($segments);

        // Special case - if the URI is just one part go home
        //
        if ($segmentCount < 2)
        {
            return new ActionMapping(
                'HomeController',
                'index'
            );
        }

        $action     = '';
        $controller = '';

        for ($i = 0; $i < $segmentCount - 1; $i++)
        {
            $controller .= ucfirst($segments[$i]);
        }

        $action = lcfirst($segments[$segmentCount - 1]);

        return new ActionMapping(
            "${controller}Controller",
            $action
        );
    }

    /**
     * Runs the action.
     *
     * @param ActionMapping $actionMapping
     *     The action to run.
     */
    private function runAction(
        ActionMapping $controllerAction
    )
    {
        $action     = $controllerAction->getAction();
        $controller = $controllerAction->getController();

        require("${this->webRootDir}/${controller}.php");

        $controllerInst = new $controller();

        $controllerInst->setWebRoot($this->webRootDir);

        $controllerInst->$action();
    }
}

?>
