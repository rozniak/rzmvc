<?php

/**
 * rzmvc.php - rzmvc Bootstrapper
 *
 * This source-code is part of the rzmvc project by Oddmatics:
 * <<https://www.oddmatics.uk>>
 *
 * Author(s): Rory Fewell <roryf@oddmatics.uk>
 */

function rzLoadLibrary(
    string $library
)
{
    $libPath = "/usr/share/rzmvc/lib/{$library}.php";

    require_once($libPath);
}

?>
