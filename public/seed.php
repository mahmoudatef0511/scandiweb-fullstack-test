<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;
use App\Seeders\DataSeeder;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$pdo = Database::getInstance();
$seeder = new DataSeeder($pdo, __DIR__ . '/data.json');
$seeder->seed();