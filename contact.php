<?php
// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and remove any extra spaces or unwanted characters
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r", "\n"), array(" ", " "), $name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Check if the required fields are filled and if the email is valid
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Bad request
        echo "Oops! There was a problem with your submission. Please complete the form and try again.";
        exit;
    }

    // The recipient email address (change this to your email)
    $recipient = "kevindu.np@gmail.com"; 
    $subject = "New Contact Us Message from $name";

    // Email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $email_headers = "From: $name <$email>\r\nReply-To: $email";

    // Send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200); // OK
        echo "Thank you! Your message has been sent.";
    } else {
        http_response_code(500); // Internal server error
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    http_response_code(403); // Forbidden
    echo "There was a problem with your submission, please try again.";
}
?>
