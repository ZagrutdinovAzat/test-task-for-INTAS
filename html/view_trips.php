<?php
require 'db_config.php';

$conn = getConnection();

$date = isset($_GET['date']) ? $_GET['date'] : null;

if ($date) {
    $trips_sql = "SELECT t.id, r.name as region, c.name as courier, t.departure_date, t.arrival_date FROM trips t JOIN regions r ON t.region_id = r.id JOIN couriers c ON t.courier_id = c.id WHERE t.departure_date = ? ORDER BY t.id ASC";
    $trips = executePreparedStatement($conn, $trips_sql, [$date]);
} else {
    $trips_sql = "SELECT t.id, r.name as region, c.name as courier, t.departure_date, t.arrival_date FROM trips t JOIN regions r ON t.region_id = r.id JOIN couriers c ON t.courier_id = c.id ORDER BY t.id ASC";
    $trips = $conn->query($trips_sql);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Trips</title>
</head>
<body>
<form id="filterForm">
    <label for="date">Date:</label>
    <input type="date" id="date" name="date" value="<?php echo $date; ?>">
    <button type="submit">Filter</button>
    <button type="button" onclick="window.location.href='view_trips.php'">View All</button>
</form>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Region</th>
        <th>Courier</th>
        <th>Departure Date</th>
        <th>Arrival Date</th>
    </tr>
    <?php while ($trip = $trips->fetch_assoc()): ?>
        <tr>
            <td><?php echo $trip['id']; ?></td>
            <td><?php echo $trip['region']; ?></td>
            <td><?php echo $trip['courier']; ?></td>
            <td><?php echo $trip['departure_date']; ?></td>
            <td><?php echo $trip['arrival_date']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<script>
    document.getElementById('filterForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var date = document.getElementById('date').value;
        window.location.href = 'view_trips.php?date=' + date;
    });
</script>
</body>
</html>
