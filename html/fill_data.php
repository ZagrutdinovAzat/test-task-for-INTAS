<?php
require 'db_config.php';

$conn = getConnection();

$regions = $conn->query("SELECT id, travel_time FROM regions");
$couriers = $conn->query("SELECT id FROM couriers");

$region_ids = [];
while ($region = $regions->fetch_assoc()) {
    $region_ids[] = $region['id'];
}

$courier_ids = [];
while ($courier = $couriers->fetch_assoc()) {
    $courier_ids[] = $courier['id'];
}

for ($i = 0; $i < 30; $i++) {
    $region_id = $region_ids[array_rand($region_ids)];
    $courier_id = $courier_ids[array_rand($courier_ids)];

    $travel_time_query = $conn->query("SELECT travel_time FROM regions WHERE id = $region_id");
    $travel_time = $travel_time_query->fetch_assoc()['travel_time'];

    $start_date = new DateTime('2023-01-01');
    $end_date = new DateTime('2023-03-31');
    $random_date = new DateTime(date('Y-m-d', random_int($start_date->getTimestamp(), $end_date->getTimestamp())));

    $departure_date = $random_date->format('Y-m-d');
    $arrival_date = $random_date->modify("+$travel_time days")->format('Y-m-d');

    $insert_sql = "INSERT INTO trips (region_id, courier_id, departure_date, arrival_date) VALUES (?, ?, ?, ?)";
    executePreparedStatement($conn, $insert_sql, [$region_id, $courier_id, $departure_date, $arrival_date]);
}

echo "Data filled successfully.";

$conn->close();
?>
