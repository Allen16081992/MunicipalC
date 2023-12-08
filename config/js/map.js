"use strict"; // Dhr. Allen Pieter
document.addEventListener('DOMContentLoaded', function () {
    // Declare stuff
    var navButtons = document.querySelectorAll('nav ul li a');
    var sections = document.querySelectorAll('section');
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
            } else if (sectionId === 'admin') {
                initializeMarker();
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
        map = L.map('map').setView([51.5765, 3.7727], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add click event listener to the map
        map.on('click', function (e) {
            // Update the input field with the clicked location's coordinates
            var locationInput = document.getElementById('location');
            locationInput.value = e.latlng.lat + ', ' + e.latlng.lng;

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

    function initializeMarker() {
        // Initialize the map globally
        var map = L.map('map').setView([51.5765, 3.7727], 12);
    
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    
        // Fetch map data from PHP using AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Extract relevant data (lat, lon)
                    const mapData = JSON.parse(xhr.responseText);

                    // Continue processing (add markers to the map)
                    mapData.forEach(entry => {
                        const klacht = entry.Klacht;
                        const lat = entry.Breedtegraad;
                        const lon = entry.Lengtegraad;

                        // Create marker with popup and add to the map
                        const marker = L.marker([lat, lon])
                            .bindPopup(klacht)  // Bind the title to the popup
                            .addTo(map);

                        // Open popup on marker click
                        marker.on('click', function() {
                            marker.openPopup();
                        });
                    });
                } else {
                    console.error('Error fetching map data:', xhr.statusText);
                }
            }
        };
        // Instantiate the file that handles data
        xhr.open('GET', 'config/viewComplaints.conf.php?mapdata', true);
        xhr.send();
    }    
});