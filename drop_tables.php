<?php

$mysqli = new mysqli("localhost", "jobuser", "TestPass!2025", "job_connect");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$tables = ['activity_log', 'notifications', 'settings', 'applications', 'candidates', 'jobs', 'companies', 'categories', 'users', 'migrations'];

$mysqli->query("SET FOREIGN_KEY_CHECKS = 0");
foreach ($tables as $table) {
    $mysqli->query("DROP TABLE IF EXISTS $table");
    echo "Dropped table $table\n";
}
$mysqli->query("SET FOREIGN_KEY_CHECKS = 1");

echo "All tables dropped.\n";
