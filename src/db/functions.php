<?php

// Generate url

/**
 * @param string $url
 * @param array $params
 * @return string
 */
function editUrlParams($url, $params)
{
    $isAnyParams = false;
    if (!empty(preg_match('/\?/isu', $url)))
        $isAnyParams = true;

    foreach ($params as $param) {
        if (empty($param[1])) {
            if (!empty(preg_match('/' . $param[0] . '=/isu', $url))) {
                $url = preg_replace('/&' . $param[0] . '=.*?($|(?=&))|' . $param[0] . '=.*?(&|$)/isu', '', $url);
            }
        } else if (empty(preg_match('/' . $param[0] . '=/isu', $url))) {
            if ($isAnyParams)
                $url .= '&';
            else $url .= '?';
            $url .= $param[0] . '=' . $param[1];
        } else {
            $url = preg_replace('/(?<=' . $param[0] . '=).*?(?=&|$)/isu', $param[1], $url);
        }
    }
    return $url;
}
