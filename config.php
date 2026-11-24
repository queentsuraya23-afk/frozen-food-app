<?php
declare(strict_types=1);

const DB_HOST = 'localhost';
const DB_NAME = 'db_frozen_food';
const DB_USER = 'root';
const DB_PASS = '';

const DB_OPTIONS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

ini_set('display_errors', '0');
ini_set('error_reporting', E_ALL & ~E_DEPRECATED);

$pdo = new PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
    DB_USER,
    DB_PASS,
    DB_OPTIONS
);
