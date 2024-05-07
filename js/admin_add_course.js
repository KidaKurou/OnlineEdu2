$(document).ready(function () {
    $(window).on("load", function () {
        var actualLink = $('.actual')[0].id;
        console.log(actualLink);
        if (actualLink === 'add-course-link') {
            addCourse({ preventDefault: function () { } });
        } else if (actualLink === 'edit-course-link') {
            editCourse({ preventDefault: function () { } });
        }
    });

    // Add Course
    $("#add-course-link").click(addCourse);

    $(document).on('click', '#add-course-btn', function () {
        $('.form-container').toggleClass('active');
    });

    $(document).on('click', '#cancel-btn-add', function () {
        $('.form-container').toggleClass('active');
    });

    $(document).on('submit', '#add-course-form', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "../processes/add_course.php",
            type: "post",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === 'success') {
                    // Show a success message
                    showAlert('Course added successfully!');

                    // Reload the courses
                    addCourse(e);
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

    function addCourse(e) {
        e.preventDefault();
        $.ajax({
            url: "../processes/add_course.php",
            type: "get",
            dataType: "json",
            success: function (response) {
                // Clear the container
                $(".admin-header-panel").html('');
                $(".courses-container").html('');

                // Create the course cards
                $('<h2></h2>').text('Add Courses').appendTo('.admin-header-panel');
                $.each(response.courses, function (i, course) {
                    var courseBlock = $('<div class="course-block"></div>');
                    var img = $('<img alt="' + course.Title + '">').appendTo(courseBlock);
                    // Load the image asynchronously
                    $.get('../processes/image.php?table=Courses&id=' + course.CourseID, function (data) {
                        img.attr('src', data);
                    });
                    // $('<img src="../processes/image.php?id=' + course.CourseID + '" alt="' + course.Title + '">').appendTo(courseBlock);
                    $('<h3></h3>').text(course.Title).appendTo(courseBlock);
                    $('<p></p>').text(course.Description).appendTo(courseBlock);
                    $('<p></p>').text('Level: ' + course.Level).appendTo(courseBlock);
                    $('<p></p>').text('Duration: ' + course.Duration + ' hours').appendTo(courseBlock);
                    courseBlock.appendTo('.courses-container');
                });

                // Create the form
                var courseBlock = $('<div class="course-block"></div>');
                var form_container_1 = $('<div class="form-container active"></div>').appendTo(courseBlock);
                var form_container_2 = $('<div class="form-container"></div>').appendTo(courseBlock);
                $('<a id="add-course-btn"></a>').appendTo(form_container_1);
                $('<div class="form-header"><h3 class="form-title">Add Course</h3><a class="cancel-btn" id="cancel-btn-add"></a></div>').appendTo(form_container_2);
                var form = $('<form class="course-form" id="add-course-form"></form>');
                $('<label for="title">Title:</label>').appendTo(form);
                $('<input type="text" id="title" name="title" required>').appendTo(form);
                $('<label for="level">Level:</label>').appendTo(form);
                var select = $('<select id="level" name="level" required></select>').appendTo(form);
                $('<option value="">Select a level</option>').appendTo(select);
                $.each(response.levels, function (i, level) {
                    $('<option value="' + level.Title + '">' + level.Title + '</option>').appendTo(select);
                });
                $('<label for="description">Description:</label>').appendTo(form);
                $('<textarea id="description" name="description" required></textarea>').appendTo(form);
                $('<label for="duration">Duration:</label>').appendTo(form);
                $('<input type="number" id="duration" name="duration" required>').appendTo(form);
                var div_upload = $('<div class="file-upload"></div>').appendTo(form);
                $('<label for="file-upload-input" id="file-upload-label">Choose an image:</label>').appendTo(div_upload);
                $('<input type="file" class="file-upload-input" id="file-upload-input" name="course-img" accept="image/*">').appendTo(div_upload);
                $('<label for="visible">Visible:</label>').appendTo(form);
                $('<input type="checkbox" id="visible" name="visible">').appendTo(form);
                $('<input type="submit" value="Add Course">').appendTo(form);
                form.appendTo(form_container_2);
                courseBlock.appendTo('.courses-container');
            },
            error: function (xhr, status, error) {
                alert("ERROR");
                console.log(xhr.responseText);
            }
        });
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
