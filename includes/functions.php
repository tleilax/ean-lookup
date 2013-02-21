<?php
function htmlReady($string)
{
    $string = htmlspecialchars($string, ENT_QUOTES);
    $string = nl2br($string);
    return $string;
}

function interpolate($string, $substitutions = array())
{
    preg_match_all('/#\{(.*?)\}/', $string, $matches, PREG_SET_ORDER);

    $replaces = array();
    foreach ($matches as $match) {
        $data    = $substitutions;
        $needles = explode('.', $match[1]);
        $needle  = array_shift($needles);

        while (isset($data[$needle]) && count($needles) > 0) {
            $data   = $data[$needle];
            $needle = array_shift($needles);
        }

        if (isset($data[$needle])) {
            $replaces[$match[0]] = $data[$needle];
        }
    }
    $string = str_replace(array_keys($replaces), array_values($replaces), $string);

    return $string;
}