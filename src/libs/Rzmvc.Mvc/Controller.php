<?php

/**
 * Controller.php - rzmvc MVC Controller
 *
 * This source-code is part of the rzmvc project by Oddmatics:
 * <<https://www.oddmatics.uk>>
 *
 * Author(s): Rory Fewell <roryf@oddmatics.uk>
 */

namespace Rzmvc\Mvc;


/**
 * Represents a controller in the MVC routing system.
 */
class Controller
{
    /**
     * The root directory of the website.
     *
     * @var string
     */
    protected $webRootDir;


    /**
     * Sets the root directory of the website.
     *
     * @param string $root
     *     The root directory of the website.
     */
    public function setWebRoot(
        string $root
    )
    {
        $this->webRootDir = $root;
    }


    /**
     * Renders the view.
     *
     * @param string $viewName
     *     The name of the view to render.
     */
    final protected function view(
        string $viewName
    )
    {
        $controller = get_class($this);
        $viewDir    =
            substr(
                $controller,
                0,
                srlen($controller) - 10
            );

        $GLOBALS['viewPath'] =
            "${this->webRootDir}/Views/${viewDir}/${viewName}.php";

        require("${this->webRootDir}/Views/_Layout.php");

        exit();
    }
}

?>
