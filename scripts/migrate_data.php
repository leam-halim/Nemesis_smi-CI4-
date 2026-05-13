<?php

$sqlitePath = '../data/dashboard.sqlite';
if (!file_exists($sqlitePath)) {
    die("SQLite database not found at $sqlitePath\n");
}

$sqlite = new SQLite3($sqlitePath);
$mysql = new mysqli('localhost', 'root', '', 'nemesis_ci4');

if ($mysql->connect_error) {
    die("MySQL Connection failed: " . $mysql->connect_error . "\n");
}

function portTable($tableName, $sqlite, $mysql) {
    echo "Porting $tableName...\n";
    $results = $sqlite->query("SELECT * FROM $tableName");
    if (!$results) {
        echo "Table $tableName not found in SQLite.\n";
        return;
    }

    $mysql->query("SET FOREIGN_KEY_CHECKS = 0");
    $mysql->query("TRUNCATE TABLE $tableName");
    $mysql->query("SET FOREIGN_KEY_CHECKS = 1");

    $count = 0;
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
        $columns = array_map(fn($col) => "`$col`", array_keys($row));
        $values = array_values($row);
        
        $placeholders = array_fill(0, count($values), '?');
        $sql = "INSERT INTO $tableName (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
        
        $stmt = $mysql->prepare($sql);
        if (!$stmt) {
            echo "Error preparing statement for $tableName: " . $mysql->error . "\n";
            continue;
        }

        $types = "";
        foreach ($values as $value) {
            if (is_null($value)) $types .= "s";
            elseif (is_int($value)) $types .= "i";
            elseif (is_double($value)) $types .= "d";
            else $types .= "s";
        }

        $stmt->bind_param($types, ...$values);
        if (!$stmt->execute()) {
            echo "Error inserting into $tableName: " . $stmt->error . "\n";
        } else {
            $count++;
        }
    }
    echo "Ported $count rows to $tableName.\n";
}

$tables = [
    'regions',
    'provinces',
    'packages',
    'region_metrics',
    'province_metrics',
    'owner_metrics',
    'package_regions',
    'package_provinces',
    'assets'
];

foreach ($tables as $table) {
    portTable($table, $sqlite, $mysql);
}

// Calculate and port national_summary
echo "Calculating national_summary...\n";
$summaryResult = $sqlite->query("
    SELECT
        COUNT(*) AS total_packages,
        COALESCE(SUM(is_priority), 0) AS total_priority_packages,
        COALESCE(SUM(potential_waste), 0) AS total_potential_waste,
        COALESCE(SUM(COALESCE(budget, 0)), 0) AS total_budget,
        COALESCE(SUM(CASE WHEN mapped_region_count = 0 THEN 1 ELSE 0 END), 0) AS unmapped_packages,
        COALESCE(SUM(CASE WHEN mapped_region_count > 1 THEN 1 ELSE 0 END), 0) AS multi_location_packages
    FROM packages
");

$summary = $summaryResult->fetchArray(SQLITE3_ASSOC);
if ($summary) {
    $mysql->query("TRUNCATE TABLE national_summary");
    $stmt = $mysql->prepare("INSERT INTO national_summary (id, total_packages, total_priority_packages, total_potential_waste, total_budget, unmapped_packages, multi_location_packages) VALUES (1, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iidiii", $summary['total_packages'], $summary['total_priority_packages'], $summary['total_potential_waste'], $summary['total_budget'], $summary['unmapped_packages'], $summary['multi_location_packages']);
    $stmt->execute();
    echo "National summary calculated and saved.\n";
}

echo "Data migration complete!\n";
