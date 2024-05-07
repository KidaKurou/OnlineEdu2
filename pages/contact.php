<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
    <link rel="stylesheet" href="../styles/contact.css">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <?php include 'header.php'; ?> <!-- Include your header file -->
    <div class="contact-page">
        <div class="contact-header">
            <h2>Contact Us</h2>
        </div>
        <div class="contact-form-container">
            <form id="contact-form">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Your name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Your email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" placeholder="Enter your message" required></textarea>

                <!-- agree with privacy policy  -->
                <div class="form-group">
                    <input type="checkbox" id="agree" name="agree" required>
                    <label for="agree">I agree with the privacy policy</label>
                </div>

                <input type="submit" id="submit-btn" value="Send">
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?> <!-- Include your footer file -->

    <script>
        $(document).ready(function() {
            $(document).on('submit', '#contact-form', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../processes/submit_contact.php",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            showAlert('Form submitted successfully!');
                            $('#contact-form')[0].reset();
                        } else {
                            alert('There was an error submitting the form.');
                        }
                    },
                    error: function() {
                        alert('There was an error submitting the form.');
                    }
                });
            });

            function showAlert(message) {
                var alertBox = $('<div></div>').addClass('alert-message').text(message);
                $('body').append(alertBox);
                alertBox.fadeIn();
                setTimeout(function() {
                    alertBox.fadeOut();
                }, 5000);
            }
        });
    </script>

</body>

</html>