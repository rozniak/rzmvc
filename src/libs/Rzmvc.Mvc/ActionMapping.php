<?php

/**
 * ActionMapping.php - Mapping for Controller Action
 *
 * This source-code is part of the rzmvc project by Oddmatics:
 * <<https://www.oddmatics.uk>>
 *
 * Author(s): Rory Fewell <roryf@oddmatics.uk>
 */

namespace Rzmvc\Mvc;


/**
 * Represents a mapping for a controller action.
 */
final class ActionMapping
{
    /**
     * The action to execute.
     *
     * @var string
     */
    private $action;

    /**
     * The controller to route to.
     *
     * @var string
     */
    private $controller;


    /**
     * Initiailizes a new instance of the ActionMapping class.
     *
     * @param string $controller
     *     The controller to route to.
     *
     * @param string $action
     *     The action to execute.
     */
    public function __construct(
        string $controller,
        string $action
    )
    {
        $this->action     = $action;
        $this->controller = $controller;
    }


    /**
     * Gets the action to execute.
     *
     * @return string
     *     The action to execute.
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Gets the controller to route to.
     *
     * @return string
     *     The controller to route to.
     */
    public function getController()
    {
        return $this->controller;
    }
}

?>
