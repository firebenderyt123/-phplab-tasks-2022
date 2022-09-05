<?php

require_once './functions.php';

$airports = require './airports.php';

$url = $_SERVER['REQUEST_URI'];
$postsPerPage = 5;

// Filtering
/**
* Here you need to check $_GET request if it has any filtering
* and apply filtering by First Airport Name Letter and/or Airport State
* (see Filtering tasks 1 and 2 below)
*/

if (isset($_GET['filter_by_first_letter'])) {
    $firstLetter = $_GET['filter_by_first_letter'];
} else {
    $firstLetter = '';
}

if (isset($_GET['filter_by_state'])) {
    $state = $_GET['filter_by_state'];
} else {
    $state = '';
}

$filteredAirports = filterByLetter($airports, $firstLetter);
$filteredAirports = filterByState($filteredAirports, $state);

// Sorting
/**
* Here you need to check $_GET request if it has sorting key
* and apply sorting
* (see Sorting task below)
*/

if (isset($_GET['sort'])) {
    $sortBy = $_GET['sort'];
} else {
    $sortBy = '';
}

$filteredAirports = sortByTag($filteredAirports, $sortBy);

// Pagination
/**
* Here you need to check $_GET request if it has pagination key
* and apply pagination logic
* (see Pagination task below)
*/

if (isset($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Airports</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<main role="main" class="container">

    <h1 class="mt-5">US Airports</h1>

    <!--
        Filtering task #1
        Replace # in HREF attribute so that link follows to the same page with the filter_by_first_letter key
        i.e. /?filter_by_first_letter=A or /?filter_by_first_letter=B

        Make sure, that the logic below also works:
         - when you apply filter_by_first_letter the page should be equal 1
         - when you apply filter_by_first_letter, than filter_by_state (see Filtering task #2) is not reset
           i.e. if you have filter_by_state set you can additionally use filter_by_first_letter
    -->
    <div class="alert alert-dark">
        Filter by first letter:

        <?php foreach (getUniqueFirstLetters($airports) as $letter): ?>
            <a href="<?= editUrlParams($url, [['filter_by_first_letter', $letter], ['page', null]]); ?>"><?= $letter ?></a>
        <?php endforeach; ?>

        <a href="/" class="float-right">Reset all filters</a>
    </div>

    <!--
        Sorting task
        Replace # in HREF so that link follows to the same page with the sort key with the proper sorting value
        i.e. /?sort=name or /?sort=code etc

        Make sure, that the logic below also works:
         - when you apply sorting pagination and filtering are not reset
           i.e. if you already have /?page=2&filter_by_first_letter=A after applying sorting the url should looks like
           /?page=2&filter_by_first_letter=A&sort=name
    -->
    <table class="table">
        <thead>
        <tr>
            <th scope="col"><a href="<?= editUrlParams($url, [['sort', 'name']]); ?>">Name</a></th>
            <th scope="col"><a href="<?= editUrlParams($url, [['sort', 'code']]); ?>">Code</a></th>
            <th scope="col"><a href="<?= editUrlParams($url, [['sort', 'state']]); ?>">State</a></th>
            <th scope="col"><a href="<?= editUrlParams($url, [['sort', 'city']]); ?>">City</a></th>
            <th scope="col">Address</th>
            <th scope="col">Timezone</th>
        </tr>
        </thead>
        <tbody>
        <!--
            Filtering task #2
            Replace # in HREF so that link follows to the same page with the filter_by_state key
            i.e. /?filter_by_state=A or /?filter_by_state=B

            Make sure, that the logic below also works:
             - when you apply filter_by_state the page should be equal 1
             - when you apply filter_by_state, than filter_by_first_letter (see Filtering task #1) is not reset
               i.e. if you have filter_by_first_letter set you can additionally use filter_by_state
        -->
        <?php $start = ($currentPage-1)*$postsPerPage; ?>
        <?php for ($i = $start; $i < $start + $postsPerPage; $i++): ?>
            <?php if (!isset($filteredAirports[$i])) break; ?>
            <tr>
                <td><?= $filteredAirports[$i]['name'] ?></td>
                <td><?= $filteredAirports[$i]['code'] ?></td>
                <td><a href="<?= editUrlParams($url, [['filter_by_state', $filteredAirports[$i]['state']], ['page', null]]); ?>"><?= $filteredAirports[$i]['state'] ?></a></td>
                <td><?= $filteredAirports[$i]['city'] ?></td>
                <td><?= $filteredAirports[$i]['address'] ?></td>
                <td><?= $filteredAirports[$i]['timezone'] ?></td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>

    <!--
        Pagination task
        Replace HTML below so that it shows real pages dependently on number of airports after all filters applied

        Make sure, that the logic below also works:
         - show 5 airports per page
         - use page key (i.e. /?page=1)
         - when you apply pagination - all filters and sorting are not reset
    -->
    <nav aria-label="Navigation">
        <ul class="pagination justify-content-center">
            <?php if ($currentPage > 1): ?>
                <li class="page-item"><a class="page-link" href="<?= editUrlParams($url, [['page', 1]]); ?>">First</a></li>
                <li class="page-item"><a class="page-link" href="<?= editUrlParams($url, [['page', $currentPage-1]]); ?>">Prev</a></li>
                <li class="page-item"><a class="page-link" href="<?= editUrlParams($url, [['page', $currentPage-1]]); ?>"><?= $currentPage-1 ?></a></li>
            <?php endif; ?>
            <li class="page-item active"><a class="page-link" href="<?= editUrlParams($url, [['page', $currentPage]]); ?>"><?= $currentPage ?></a></li>
            <?php $lastPage = ceil(count($filteredAirports) / $postsPerPage); ?>
            <?php if ($currentPage < $lastPage): ?>
                <li class="page-item"><a class="page-link" href="<?= editUrlParams($url, [['page', $currentPage+1]]); ?>"><?= $currentPage+1 ?></a></li>
                <li class="page-item"><a class="page-link" href="<?= editUrlParams($url, [['page', $currentPage+1]]); ?>">Next</a></li>
                <li class="page-item"><a class="page-link" href="<?= editUrlParams($url, [['page', $lastPage]]); ?>">Last</a></li>
            <?php endif; ?>
        </ul>
    </nav>

</main>
</html>
