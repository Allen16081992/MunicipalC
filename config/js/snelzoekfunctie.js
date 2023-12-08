// Define the submitForm function globally
function submitForm() {
    var selectedValue = document.getElementById("zoekbalk").value;

    fetch("config/viewComplaints.conf.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'zoekbalk=' + encodeURIComponent(selectedValue),
    })
    .then(response => response.json())
    .then(data => {
        console.log("Server response:", data);

        if (data.error) {
            console.error("Server error:", data.error);
        } else {
            document.getElementById("displayArea").innerHTML = `
                <h3>${data.Klacht}</h3>
                <span>Melder: ${data.Naam}</span>
                <span>${data.Email}</span>
                <p>${data.Beschrijving}</p>
            `;
            document.getElementById("displayArea").classList.remove("hidden");
        }
    })
    .catch(error => {
        console.error("Fetch error:", error);
    });
}

document.addEventListener("DOMContentLoaded", function () {
    // Add any additional initialization code if needed
});