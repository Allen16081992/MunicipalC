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

    // Add click event listeners to navigation buttons and the button inside the section
    navButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            handleButtonClick(event);
        });
    });

    // Add click event listener to the button inside the section
    var sectionButton = document.querySelector('section button');
    if (sectionButton) {
        sectionButton.addEventListener('click', function (event) {
            handleButtonClick(event);
        });
    };

    function handleButtonClick(event) {
        event.preventDefault();
        var button = event.target;
        var sectionId = button.getAttribute('data-section');
        showSection(sectionId);

        // Check if the button clicked is the Logout button
        if (sectionId === 'logout') {
            // Redirect to logout.php
            window.location.href = 'logout.php';
        }
    }
});