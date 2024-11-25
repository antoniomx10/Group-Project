<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.html');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();

echo "<h1>Your Bookings, $username</h1>";

$query = "SELECT reservations.id, rooms.room_type, reservations.start_date, reservations.end_date, reservations.total_cost, reservations.quantity 
          FROM reservations 
          JOIN rooms ON reservations.room_id = rooms.id 
          WHERE reservations.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<table border='1'>
        <tr>
            <th>Booking ID</th>
            <th>Room Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Total Cost</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['room_type']}</td>
            <td>{$row['start_date']}</td>
            <td>{$row['end_date']}</td>
            <td>\${$row['total_cost']}</td>
            <td>{$row['quantity']}</td>
            <td>
                <form method='POST' action='cancel_booking.php'>
                    <input type='hidden' name='booking_id' value='{$row['id']}'>
                    <button type='submit'>Cancel</button>
                </form>
            </td>
          </tr>";
}
echo "</table>";
echo "<br><a href='rooms.php'>Back to Rooms</a>";

$stmt->close();
$conn->close();
?>
