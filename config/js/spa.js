"use strict"; // Dhr. Allen Pieter
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
        }
    }

    // Add click event listeners to navigation buttons
    navButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            var sectionId = button.getAttribute('data-section');
            showSection(sectionId);

            // Check if the button clicked is the Logout button
            if (sectionId === 'logout') {
                // Redirect to logout.php
                window.location.href = 'logout.php';
            }
        });
    });
});