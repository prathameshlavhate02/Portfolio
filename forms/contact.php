<?php
/**
 * IMPORTANT: This code includes error reporting for debugging purposes.
 * It's recommended to remove these three lines when your site goes live.
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Set the recipient email address.
 * UPDATE THIS TO YOUR EMAIL ADDRESS.
 */
$recipient = "prathameshlavhate02@gmail.com";

// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and get the form fields
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Basic validation: Check if required fields are empty or email is invalid
    if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Set a "Bad Request" response code
        echo "Please complete the form and try again.";
        exit;
    }

    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Subject: $subject\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers to show who the email is from
    $email_headers = "From: $name <$email>";

    // Attempt to send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200); // Set a "OK" response code
        echo "Your message has been sent. Thank you!";
    } else {
        http_response_code(500); // Set an "Internal Server Error" response code
        echo "Oops! Something went wrong and we couldn't send your message.";
    }

} else {
    // If the request method is not POST, deny access
    http_response_code(403); // Set a "Forbidden" response code
    echo "There was a problem with your submission, please try again.";
}
?>