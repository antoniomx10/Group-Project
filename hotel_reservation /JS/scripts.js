
document.querySelector('form').onsubmit = function() {
    var startDate = document.querySelector('input[name="start_date"]').value;
    var endDate = document.querySelector('input[name="end_date"]').value;
    if (new Date(startDate) >= new Date(endDate)) {
        alert("End date must be after the start date.");
        return false;
    }
    return true;
}

document.addEventListener("DOMContentLoaded", () => {
    const bookingForm = document.querySelectorAll("bookingForm");
    bookingForms.forEach((form) => {
        form.addEventListener("submit", (event) => {
            // Find the start and end date for this specific form
            const startDate = form.querySelector(".startDate").value;
            const endDate = form.querySelector(".endDate").value;

            // Validate the dates when form is submitted
            if (!validateBookingDates(startDate, endDate)) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });
    }
});


function updateRoomAvailability(roomId, isAvailable) {
    const roomElement = document.getElementById(`room-${roomId}`);
    if (roomElement) {
        roomElement.textContent = isAvailable ? "Available" : "Booked";
    }
}

