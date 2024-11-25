<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.html');
    exit;
}

if ($_POST['start_date'] >= $_POST['end_date']) {
    echo "End date must be later than start date.";
    echo "<br><a href='view_bookings.php'>Back to Bookings</a>";
    exit;
}

// Check availability on the server-side
$room_id = $_POST['room_id'];
$quantity = $_POST['quantity'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

// Query to check availability
$stmt = $conn->prepare("SELECT price_per_night, availability FROM rooms WHERE id = ?");
$stmt->bind_param("i", $room_id);
$stmt->execute();
$stmt->bind_result($price_per_night, $availability);
if (!$stmt->fetch()) {
    echo "Room not found or an error occurred.";
    echo "<a href='view_bookings.php'>Back to Bookings</a>";
    $stmt->close();
    exit;
}

    if ($quantity > $availability) {
        echo "Not enough rooms available.";
        echo "<a href='view_bookings.php'>Back to Bookings</a>";
        $stmt->close();
        exit;
    }

    $total_cost = $price_per_night * $quantity;
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO reservations (user_id, room_id, start_date, end_date, total_cost, quantity) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissdi", $_SESSION['user_id'], $room_id, $start_date, $end_date, $total_cost, $quantity);
    if ($stmt->execute()) {
    $stmt->close();

    $stmt = $conn->prepare("UPDATE rooms SET availability = availability - ? WHERE id = ?");
    $stmt->bind_param("ii", $quantity, $room_id);
    $stmt->execute();
    $stmt->close();

    echo "Room booked successfully. <a href='rooms.php'>Back to Rooms</a>";
    } else {
        echo "Error booking room. Please try again later.";
        echo "<a href='view_bookings.php'>Back to Bookings</a>";
    }

$conn->close();
?>
