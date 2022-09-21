<?php
/**
 * The $airports variable contains array of arrays of airports (see airports.php)
 * What can be put instead of placeholder so that function returns the unique first letter of each airport name
 * in alphabetical order
 *
 * Create a PhpUnit test (GetUniqueFirstLettersTest) which will check this behavior
 *
 * @param  array  $airports
 * @return string[]
 */
function getUniqueFirstLetters(array $airports)
{
    $firstLetters = [];
    foreach ($airports as $airport) {
        $firstLetter = mb_strtoupper(mb_substr($airport['name'], 0, 1));
        if (!in_array($firstLetter, $firstLetters)) {
            array_push($firstLetters, $firstLetter);
        }
    }
    sort($firstLetters);

    return $firstLetters;
}

// Filters

/**
 * @param  array $airports
 * @param  string $letter
 * @return array
 */
function filterByLetter(array $airports, string $letter)
{
    if (empty($letter)) {
        return $airports;
    }

    $result = [];
    foreach ($airports as $airport) {
        if ($letter == mb_strtoupper(mb_substr($airport['name'], 0, 1))) {
            array_push($result, $airport);
        }
    }
    return $result;
}

/**
 * @param  array $airports
 * @param  string $state
 * @return array
 */
function filterByState(array $airports, string $state)
{
    if (empty($state)) {
        return $airports;
    }

    $result = [];
    foreach ($airports as $airport) {
        if (mb_strtolower($state) == mb_strtolower($airport['state'])) {
            array_push($result, $airport);
        }
    }
    return $result;
}


// Sorting

/**
 * @param  array $airports
 * @param  string $sortBy
 * @return array
 */
function sortByTag(array $airports, string $sortBy)
{
    if (empty($sortBy))
        return $airports;

    if ($sortBy == 'name') {
        usort($airports, function($a, $b) {
            return $a['name'] <=> $b['name'];
        });
    } elseif ($sortBy == 'code') {
        usort($airports, function($a, $b) {
            return $a['code'] <=> $b['code'];
        });
    } elseif ($sortBy == 'state') {
        usort($airports, function($a, $b) {
            return $a['state'] <=> $b['state'];
        });
    } elseif ($sortBy == 'city') {
        usort($airports, function($a, $b) {
            return $a['city'] <=> $b['city'];
        });
    }
    return $airports;
}


// Generate url

/**
 * @param string $url
 * @param array $params
 * @return string
 */
function editUrlParams($url, $params)
{
    $isAnyParams = false;
    if (!empty(preg_match('/\?/isu', $url))) {
        $isAnyParams = true;
    }

    foreach ($params as $param) {
        if (empty($param[1])) {
            if (!empty(preg_match('/' . $param[0] . '=/isu', $url))) {
                $url = preg_replace('/&' . $param[0] . '=.*?($|(?=&))|' . $param[0] . '=.*?(&|$)/isu', '', $url);
            }
        } elseif (empty(preg_match('/' . $param[0] . '=/isu', $url))) {
            if ($isAnyParams) {
                $url .= '&';
            } else {
                $url .= '?';
            }
            $url .= $param[0] . '=' . $param[1];
        } else {
            $url = preg_replace('/(?<=' . $param[0] . '=).*?(?=&|$)/isu', $param[1], $url);
        }
    }

    return $url;
}
