$(document).ready(function () {
    // Deleted Course
    $("#deleted-course-link").click(showCourses);

    $(document).on('submit', '#restore-course-form', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "../processes/restore_course.php",
            type: "post",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === 'success') {
                    // Show a success message
                    showAlert('Course restored successfully!');

                    // Reload the courses
                    showCourses(e);
                    updateCourse($(e.target).parent().parent());
                    // console.log($(e.target).parent().parent());
                } else {
                    // Show an error message
                    alert('An error occurred: ' + response.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Handle AJAX errors
                alert('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        });
    });

    function showCourses(e) {
        e.preventDefault();
        $.ajax({
            url: "../processes/restore_course.php",
            type: "get",
            dataType: "json",
            success: function (response) {
                // Clear the container
                $(".admin-header-panel").html('');
                $(".courses-container").html('');

                // Create the course cards
                $('<h2></h2>').text('Deleted Courses').appendTo('.admin-header-panel');
                $.each(response.courses, function (i, course) {
                    let courseBlock = $('<div class="course-block"></div>');
                    let form_container_1 = $('<div class="form-container_1 active"></div>').appendTo(courseBlock);
                    var form_restore = $('<form id="restore-course-form"></form>').appendTo(form_container_1);
                    $('<input type="hidden" name="CourseID" value="' + course.CourseID + '">').appendTo(form_restore);
                    $('<input type="submit" value="" id="restore-course-btn" class="restore-btn">').appendTo(form_restore);
                    form_restore.appendTo(form_container_1);
                    let img = $('<img alt="' + course.Title + '">').appendTo(form_container_1);
                    // Load the image asynchronously
                    $.get('../processes/image.php?table=DeletedCourses&id=' + course.CourseID, function (data) {
                        img.attr('src', data);
                    });
                    $('<h3></h3>').text(course.Title).appendTo(form_container_1);
                    $('<p></p>').text(course.Description).appendTo(form_container_1);
                    $('<p></p>').text('Level: ' + course.Level).appendTo(form_container_1);
                    $('<p></p>').text('Duration: ' + course.Duration + ' hours').appendTo(form_container_1);
                    courseBlock.appendTo('.courses-container');
                });
            },
            error: function (xhr, status, error) {
                alert("ERROR");
                console.log(xhr.responseText);
            }
        });
    }

    // Update Course view to avoid reloading all the courses as showCourses function
    function updateCourse(course_block) {
        course_block.remove();
    }

    function showAlert(message) {
        var alertBox = $('<div></div>').addClass('alert-message').text(message);
        $('body').append(alertBox);
        alertBox.fadeIn();
        setTimeout(function () {
            alertBox.fadeOut();
        }, 5000);
    }
});
