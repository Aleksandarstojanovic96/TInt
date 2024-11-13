<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizing input data
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    // Verify reCAPTCHA
    $secretKey = '6LdnSl0qAAAAACsXUtTsRi_E8t-QSh6tt5qB5DVa'; // Add your secret key here
    $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
    $responseData = json_decode($verifyResponse);
    if ($responseData->success) {
        // Email Configuration
        $to = "stojanaleksandrovic@gmail.com"; // Replace with your actual email address
        $subject = "New Contact Form Submission from $name"; // Custom subject line
        $body = "Name: $name\nEmail: $email\nMessage: $message";
        $headers = "From: $email";
        // Sending the email
        if (mail($to, $subject, $body, $headers)) {
            echo "Email sent successfully!";
        } else {
            echo "Failed to send email.";
        }
    } else {
        echo "reCAPTCHA verification failed. Please try again.";
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo "Method not allowed.";
    exit();
}
?>