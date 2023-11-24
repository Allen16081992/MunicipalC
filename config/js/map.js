
document.addEventListener('DOMContentLoaded', function () {
    // Get all navigation buttons
    var navButtons = document.querySelectorAll('nav ul li a');

    // Get all sections
    var sections = document.querySelectorAll('section');

    // Function to show a specific section
    function showSection(sectionId) {
        // Hide all sections
        sections.forEach(function (section) {
            section.classList.add('hidden');
        });

        // Show the selected section
        var selectedSection = document.getElementById(sectionId);
        if (selectedSection) {
            selectedSection.classList.remove('hidden');

            // If the selected section is "complaints", initialize the map
            if (sectionId === 'complaints') {
                initializeMap();
            }
        }
    }

    // Add click event listeners to navigation buttons
    navButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            var sectionId = button.getAttribute('data-section');
            showSection(sectionId);
        });
    });

    // Leaflet map initialization script
    function initializeMap() {
        var map = L.map('map').setView([51.5735, 3.8396], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    }
});