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

    // Edit Course
    $("#edit-course-link").click(editCourse);

    // Delete Course
    // $("#delete-course-link").click();

    // User Info
    // $("#user-info-link").click();

    $(document).on('click', '#add-course-btn', function () {
        $('.form-container').toggleClass('active');
    });

    $(document).on('click', '#edit-course-btn', function () {
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
                    // alert('Course added successfully');
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
                $(".admin-header").html('');
                $(".courses-container").html('');

                // Create the course cards
                $('<h2></h2>').text('Add Courses').appendTo('.admin-header');
                $.each(response.courses, function (i, course) {
                    var courseBlock = $('<div class="course-block"></div>');
                    $('<img src="../processes/image.php?id=' + course.CourseID + '" alt="' + course.Title + '">').appendTo(courseBlock);
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
                $('<button id="add-course-btn">+</button>').appendTo(form_container_1);
                var form = $('<form id="add-course-form"></form>');
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
                $('<label for="course-img">Choose an image:</label>').appendTo(form);
                $('<input type="file" id="course-img" name="course-img" accept="image/*" required>').appendTo(form);
                $('<label for="visible">Visible:</label>').appendTo(form);
                $('<input type="checkbox" id="visible" name="visible" value="1">').appendTo(form);
                $('<input type="submit" value="Add Course">').appendTo(form);
                form.appendTo(form_container_2);
                courseBlock.appendTo('.courses-container');
            },
            error: function (xhr, status, error) {
                alert("ERROR");
                console.log(xhr.responseText);
            }
        });
    };

    function editCourse(e) {
        $("#add-course-link").toggleClass('actual');
        $("#edit-course-link").toggleClass('actual');
        e.preventDefault();
        $.ajax({
            url: "../processes/edit_course.php",
            type: "get",
            dataType: "json",
            success: function (response) {
                // Clear the container
                $(".admin-header").html('');
                $(".courses-container").html('');

                // Create the course cards
                $('<h2></h2>').text('Edit Courses').appendTo('.admin-header');
                $.each(response.courses, function (i, course) {
                    var courseBlock = $('<div class="course-block"></div>');
                    var form_container_1 = $('<div class="form-container active"></div>').appendTo(courseBlock);
                    $('<img src="../processes/image.php?id=' + course.CourseID + '" alt="' + course.Title + '">').appendTo(form_container_1);
                    $('<h3></h3>').text(course.Title).appendTo(form_container_1);
                    $('<p></p>').text(course.Description).appendTo(form_container_1);
                    $('<p></p>').text('Level: ' + course.Level).appendTo(form_container_1);
                    $('<p></p>').text('Duration: ' + course.Duration + ' hours').appendTo(form_container_1);
                    $('<p></p>').text('Visible: ' + Boolean(course.Hide)).appendTo(form_container_1);
                    $('<a id="edit-course-btn" class="btn">Edit</a>').appendTo(form_container_1);

                    var form_container_2 = $('<div class="form-container"></div>').appendTo(courseBlock);
                    var form = $('<form id="add-course-form"></form>');
                    $('<label for="title">Title:</label>').appendTo(form);
                    $('<input type="text" id="title" name="title" value="' + course.Title + '" required>').appendTo(form);
                    $('<label for="level">Level:</label>').appendTo(form);
                    var select = $('<select id="level" name="level" required></select>').appendTo(form);
                    $('<option value="">Select a level</option>').appendTo(select);
                    $.each(response.levels, function (i, level) {
                        $('<option value="' + level.Title + '">' + level.Title + '</option>').appendTo(select);
                    });
                    $('<label for="description">Description:</label>').appendTo(form);
                    $('<textarea id="description" name="description" required>' + course.Description + '</textarea>').appendTo(form);
                    $('<label for="duration">Duration:</label>').appendTo(form);
                    $('<input type="number" id="duration" name="duration" value="' + course.Duration + '" required>').appendTo(form);
                    $('<label for="course-img">Choose an image:</label>').appendTo(form);
                    $('<input type="file" id="course-img" name="course-img" accept="image/*" required>').appendTo(form);
                    $('<label for="visible">Visible:</label>').appendTo(form);
                    $('<input type="checkbox" id="visible" name="visible" value="1" ' + (course.Hide ? 'checked' : '') + '>').appendTo(form);
                    $('<input type="submit" value="Edit Course">').appendTo(form);
                    form.appendTo(form_container_2);

                    courseBlock.appendTo('.courses-container');
                });

            },
            error: function (xhr, status, error) {
                alert("ERROR");
                console.log(xhr.responseText);
            }
        });
    }

    function editCard(e) {
        e.preventDefault();
        $.ajax({
            url: "../processes/edit_card.php",
            type: "get",
            dataType: "json",
            success: function (response) {
                // Clear the container
                $(".admin-header").html('');
                $(".courses-container").html('');
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
