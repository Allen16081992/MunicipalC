"use strict"; // Dhr. Allen Pieter
// Invoked by our quickSearch.
function submitForm() {
    var selectedValue = document.getElementById("zoekbalk").value;

    // Use stupid API (Application Programming Interface) to make HTTP requests to server
    fetch("config/viewComplaints.conf.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'zoekbalk=' + encodeURIComponent(selectedValue),
    })
    // Catch response from server as JSON
    .then(response => response.json())
    .then(data => {
        // Make log when server is fucked up...
        if (data.error) {
            console.error("Server error:", data.error);
        } else {
            // Finally show that utterly dispicable data...
            document.getElementById("displayArea").innerHTML = `
                <form action="config/complaint.conf.php" method="post">
                    <h3>${data.Klacht}</h3>
                    <input type="hidden" value="${data.ID}" name="comID">
                    <input type="hidden" value="${data.Breedtegraad, data.Lengtegraad}" name="location">
                    <input type="text" value="${data.Naam}" name="name" readonly>
                    <input type="text" value="${data.Email}" name="email" readonly>

                    <input type="text" value="${data.Klacht}" name="title">
                    <textarea name="desc" rows="4" cols="50">${data.Beschrijving}</textarea>
                    <button type="submit" name="updCom">Wijzigen</button>
                    <button type="submit" name="delCom" class="delete">Verwijderen</button>
                </form>
            `;
            document.getElementById("displayArea").classList.remove("hidden");
        }
    })
    // Try to catch anything fucky related to 'fetch' operation
    .catch(error => {
        console.error("Fetch error:", error);
    });
}

// Run it when page finishes loading...
document.addEventListener("DOMContentLoaded", function () {
    // Add any additional initialization code if needed
});