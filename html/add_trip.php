<?php
require 'db_config.php';

$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $region_id = $_POST['region_id'];
    $courier_id = $_POST['courier_id'];
    $departure_date = $_POST['departure_date'];
    $travel_time = $_POST['travel_time'];
    $arrival_date = date('Y-m-d', strtotime($departure_date . " +$travel_time days"));

    $check_sql = "SELECT * FROM trips WHERE courier_id = ? AND (departure_date = ? OR arrival_date = ? OR (departure_date <= ? AND arrival_date >= ?))";
    $check_result = executePreparedStatement($conn, $check_sql, [$courier_id, $departure_date, $departure_date, $departure_date, $departure_date]);

    if ($check_result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Courier is already on a trip on the selected date."]);
    } else {
        $insert_sql = "INSERT INTO trips (region_id, courier_id, departure_date, arrival_date) VALUES (?, ?, ?, ?)";
        executePreparedStatement($conn, $insert_sql, [$region_id, $courier_id, $departure_date, $arrival_date]);
        echo json_encode(["status" => "success", "message" => "Trip added successfully."]);
    }
    exit;
}

$regions = $conn->query("SELECT id, name FROM regions");
$couriers = $conn->query("SELECT id, name FROM couriers");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Trip</title>
</head>
<body>
<form id="addTripForm">
    <label for="region_id">Region:</label>
    <select id="region_id" name="region_id">
        <?php while ($region = $regions->fetch_assoc()): ?>
            <option value="<?php echo $region['id']; ?>"><?php echo $region['name']; ?></option>
        <?php endwhile; ?>
    </select>
    <br>
    <label for="courier_id">Courier:</label>
    <select id="courier_id" name="courier_id">
        <?php while ($courier = $couriers->fetch_assoc()): ?>
            <option value="<?php echo $courier['id']; ?>"><?php echo $courier['name']; ?></option>
        <?php endwhile; ?>
    </select>
    <br>
    <label for="departure_date">Departure Date:</label>
    <input type="date" id="departure_date" name="departure_date">
    <br>
    <label for="travel_time">Travel Time (days):</label>
    <input type="number" id="travel_time" name="travel_time">
    <br>
    <button type="submit">Add Trip</button>
</form>

<script>
    document.getElementById('addTripForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        fetch('add_trip.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "error") {
                    alert(data.message);
                } else {
                    alert(data.message);
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>
</body>
</html>
