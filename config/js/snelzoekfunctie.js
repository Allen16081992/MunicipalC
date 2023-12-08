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
                <h3>${data.Klacht}</h3>
                <span>Melder: ${data.Naam}</span>
                <span>${data.Email}</span>
                <p>${data.Beschrijving}</p>
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