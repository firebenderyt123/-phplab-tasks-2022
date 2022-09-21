<?php
/**
 * TODO
 *  Write DPO statements to create following tables:
 *
 *  # airports
 *   - id (unsigned int, autoincrement)
 *   - name (varchar)
 *   - code (varchar)
 *   - city_id (relation to the cities table)
 *   - state_id (relation to the states table)
 *   - address (varchar)
 *   - timezone (varchar)
 *
 *  # cities
 *   - id (unsigned int, autoincrement)
 *   - name (varchar)
 *
 *  # states
 *   - id (unsigned int, autoincrement)
 *   - name (varchar)
 */

/** @var \PDO $pdo */
require_once './pdo_ini.php';

// cities
$sql = <<<'SQL'
CREATE TABLE `cities` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(63),
	PRIMARY KEY (`id`)
);
SQL;
$pdo->exec($sql);

// TODO states
$sql = <<<'SQL'
CREATE TABLE states (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(63),
	PRIMARY KEY (`id`)
);
SQL;
$pdo->exec($sql);

// TODO airports
$sql = <<<'SQL'
CREATE TABLE airports (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(63) NOT NULL,
    `code` varchar(3) NOT NULL,
    `city_id` int(10) unsigned NOT NULL,
    `state_id` int(10) unsigned NOT NULL,
    `address` varchar(127) NOT NULL,
    `timezone` varchar(31) NOT NULL,
	PRIMARY KEY (`id`),
    FOREIGN KEY (`city_id`)  REFERENCES `cities` (`id`),
    FOREIGN KEY (`state_id`)  REFERENCES `states` (`id`)
);
SQL;
$pdo->exec($sql);
