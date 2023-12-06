"use strict"; // Dhr. Allen Pieter

function submitForm() {
    // Serialize the form data
    var formData = $("#quickSearch").serialize(); // Correct form ID

    // Send an AJAX request to your server
    $.ajax({
        type: "POST", // Use POST or GET based on your needs
        url: "config/viewComplaints.conf.php", // Replace with your server-side processing file
        data: formData,
        success: function(data) {
            // Log the entire data object to the console
            console.log(data);
        
            // Remove the 'hidden' class from the displayArea
            $("#displayArea").removeClass("hidden");
        
            // Manually set the content on the displayArea from the console data
            $("#displayArea > h3").html(data['Naam'] || "No Name"); // Adjust property name
            $("#displayArea > span:eq(0)").html(data['Email'] || "No Email"); // Handle null or undefined values
            $("#displayArea > span:eq(1)").html(data['Klacht'] || "No Complaint"); // Handle null or undefined values
            $("#displayArea > p").html(data['Beschrijving'] || "No Description"); // Handle null or undefined values
        },                                          
        error: function(jqXHR, textStatus, errorThrown) {
            // Log the complete XHR object
            console.error("Complete XHR object:", jqXHR);
        
            // Log any errors to the console
            console.error("AJAX Error:", textStatus, errorThrown);
        }        
    });
}