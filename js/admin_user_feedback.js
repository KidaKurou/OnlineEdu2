$(document).ready(function () {
    // User Feedback
    $("#users-feedback-link").click(showFeedback);

    // Show full feedback message when a feedback block is clicked
    $(document).on('click', '.feedback-block', function() {
        var feedback = $(this).data('feedback');
        $('.feedback-details').html('<h2>Message</h2><h3>' + feedback.name + '</h3><p>' + feedback.email + '</p><p>' + feedback.message + '</p>');
    });

    function showFeedback(e) {
        e.preventDefault();
        $.ajax({
            url: "../processes/get_feedback.php",
            type: "get",
            dataType: "json",
            success: function (response) {
                // Clear the container
                $(".admin-header-panel").html('');
                $(".courses-container").html('<div class="feedback-list"></div><div class="feedback-details"></div>');
                $('<h2></h2>').text('User Feedback').appendTo('.admin-header-panel');
                $('<h2></h2>').text('List').appendTo('.feedback-list');
                $('<h2></h2>').text('Message').appendTo('.feedback-details');
                
                // Create the feedback messages
                $.each(response.feedback, function (i, feedback) {
                    let feedbackBlock = $('<div class="feedback-block"></div>').data('feedback', feedback);
                    $('<h3></h3>').text(feedback.name).appendTo(feedbackBlock);
                    // $('<p></p>').text(feedback.message).appendTo(feedbackBlock);
                    feedbackBlock.appendTo('.feedback-list');
                });
            },
            error: function (xhr, status, error) {
                alert("ERROR");
                console.log(xhr.responseText);
            }
        });
    }
});
