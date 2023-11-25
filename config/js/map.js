document.addEventListener('DOMContentLoaded', function () {
    var navButtons = document.querySelectorAll('nav ul li a');
    var sections = document.querySelectorAll('section');

    // Declare map as a global variable
    var map;

    function showSection(sectionId) {
        sections.forEach(function (section) {
            section.classList.add('hidden');
        });

        var selectedSection = document.getElementById(sectionId);
        if (selectedSection) {
            selectedSection.classList.remove('hidden');

            if (sectionId === 'complaints') {
                initializeMap();
            }
        }
    }

    navButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            var sectionId = button.getAttribute('data-section');
            showSection(sectionId);
        });
    });

    function initializeMap() {
        // Initialize the map globally
        map = L.map('map').setView([51.5735, 3.8396], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add click event listener to the map
        map.on('click', function (e) {
            // Update the input field with the clicked location's coordinates
            var locationInput = document.getElementById('location');
            locationInput.value = e.latlng.lat + ', ' + e.latlng.lng;

            // Define a custom icon
            //var customIcon = L.icon({
            //    iconUrl: 'path/to/your/icon.png',
            //    iconSize: [32, 32], // size of the icon
            //    iconAnchor: [16, 32], // point of the icon which will correspond to marker's location
            //    popupAnchor: [0, -32] // point from which the popup should open relative to the iconAnchor
            //});

            // Add a marker to the map at the clicked location
            var marker = L.marker(e.latlng).addTo(map);

            // Add a click event listener to the marker
            marker.on('click', function () {
                // Ask for confirmation to remove the marker
                var confirmRemove = confirm('Do you want to remove this marker?');

                // If the user confirms, remove the marker
                if (confirmRemove) {
                    map.removeLayer(marker);
                    locationInput.value = '';
                }
            });
        });
    }
});