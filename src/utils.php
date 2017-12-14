<?php
// @codeCoverageIgnoreStart
/**
 * Prints HTML human-readable information about a variable
 *
 * @param $var
 */
function d($var)
{
    alfredDump($var, false, true);
}

/**
 * Prints (and DIE) HTML human-readable information about a variable
 *
 * @param $var
 */
function dd($var)
{
    alfredDump($var, true, true);
}

/**
 * Prints human-readable information about a variable
 *
 * @param $var
 */
function s($var)
{
    alfredDump($var, false, false);
}

/**
 * Prints (and DIE) human-readable information about a variable
 *
 * @param $var
 */
function sd($var)
{
    alfredDump($var, true, false);
}

/**
 * Show var content
 *
 * @param mixed $v    var to watch
 * @param bool  $die die (true by default)
 * @param bool  $html
 */

function alfredDump($v, $die = true, $html = false)
{
    $calledFrom = debug_backtrace();
    echo "\n=== DEBUG FROM " . substr(
            $calledFrom[1]['file'],
            1
        ) . ' (line ' . $calledFrom[1]['line'] . ")\n\n";
    if ($html) {
        echo '<pre>';
    }

    print_r($v);

    echo "\n\n=== FIN DEBUG \n";
    if ($html) {
        echo '</pre>';
    }
    if (true === $die) {
        die();
    }
}
// @codeCoverageIgnoreEnd
