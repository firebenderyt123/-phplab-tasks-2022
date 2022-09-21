<?php

/**
 * @param  PDO $pdo
 * @return array
 */
function getFirstLetters(\PDO $pdo)
{
    $sth = $pdo->query('SELECT DISTINCT LEFT(name, 1) AS letters FROM airports ORDER BY letters');
    $sth->setFetchMode(\PDO::FETCH_NUM);
    $sth->execute();
    $letters = $sth->fetchAll();
    return $letters;
}

/**
 * @param  PDO $pdo
 * @param  array $filters
 * @param  array $orders
 * @param  array $limits - two items (first - start from, second - count of airports to view)
 * @return array
 */
function getAirports(\PDO $pdo, array $filters = [], array $orders = [], array $limits=[])
{
    $sql = 'SELECT
        airports.name,
        airports.code,
        cities.name as city_name,
        states.name as state_name,
        airports.address,
        airports.timezone
     FROM airports
     LEFT JOIN cities on cities.id = city_id
     LEFT JOIN states on states.id = state_id';
    if (!empty($filters)) {
        foreach ($filters as $filter) {
            if (!empty($filter[1])) {
                if (!str_contains($sql, ' WHERE '))
                    $sql .= ' WHERE ';
                $sql .= $filter[0] . " LIKE '" . $filter[1] . "' AND ";
            }
        }
        if (str_contains($sql, ' WHERE '))
            $sql = mb_substr($sql, 0, -5);
    }
    if (!empty($orders)) {
        foreach ($orders as $order) {
            if (!empty($order)) {
                if (!str_contains($sql, ' ORDER BY '))
                    $sql .= ' ORDER BY ';
                $sql .= $order . ', ';
            }
        }
        if (str_contains($sql, ' ORDER BY '))
            $sql = mb_substr($sql, 0, -2);
    }
    if (!empty($limits))
        $sql .= ' LIMIT ' . implode(', ', $limits);
    $sth = $pdo->query($sql);
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute();
    $airports = $sth->fetchAll();
    return $airports;
}

/**
 * Get total count of airports using filters
 *
 * @param  PDO $pdo
 * @param  array $filters
 * @return int
 */
function getAirportsCount(\PDO $pdo, array $filters = [])
{
    return count(getAirports($pdo, $filters));
}
