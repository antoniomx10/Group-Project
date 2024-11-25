<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.html');
    exit;
}

$result = $conn->query("SELECT * FROM rooms WHERE availability > 0");

echo "<h1>Available Rooms</h1>";
echo "<a href='view_bookings.php'>View My Bookings</a> / <span>Cancel Booking</span>"; 
echo "<br><a href='../index.html'>Back to Main Page</a>";
if ($result->num_rows == 0) {
    echo "<p>No rooms are available at the moment. Please check back later.</p>";
} else {
    echo "<table class='table table-striped' border='1'>
            <thead>
                <tr>
                    <th>Room ID</th>
                    <th>Room Type</th>
                    <th>Price Per Night</th>
                    <th>Availability</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['room_type']}</td>
            <td>\${$row['price_per_night']}</td>
            <td>{$row['availability']}</td>
            <td>
                <form class='bookingForm' method='POST' action='reservation.php'>
                    <input type='hidden' name='room_id' value='{$row['id']}'>
                    <input type='number' name='quantity' min='1' max='{$row['availability']}' required>
                    <input type='date' class='startDate' name='start_date' required>
                    <input type='date' class='endDate' name='end_date' required>
                    <button type='submit'class='btn btn-primary'>Book</button>
                </form>
            </td>
          </tr>";
}
echo "</tbody></table>";
}

$conn->close();
?>
