<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.html');
    exit;
}

if (isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    $stmt = $conn->prepare("SELECT room_id, quantity FROM reservations WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $stmt->bind_result($room_id, $quantity);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM reservations WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("UPDATE rooms SET availability = availability + ? WHERE id = ?");
    $stmt->bind_param("ii", $quantity, $room_id);
    $stmt->execute();
    $stmt->close();

    echo "Booking canceled successfully. <a href='view_bookings.php'>Back to Bookings</a>";
}

$conn->close();
?>
