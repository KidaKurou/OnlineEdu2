$(document).ready(function () {
    // Edit Course
    $("#edit-course-link").click(editCourse);

    $(document).on('click', '#edit-course-btn', function () {
        let form_container_1 = $(this).parent();
        let form_container_2 = form_container_1.next();
        form_container_2.toggleClass('active');
        form_container_1.toggleClass('active');
    });

    $(document).on('click', '#cancel-btn-edit', function () {
        let form_container_1 = $(this).parent().parent();
        let form_container_2 = form_container_1.prev();
        form_container_2.toggleClass('active');
        form_container_1.toggleClass('active');
    });

    $(document).on('submit', '#edit-course-form', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "../processes/edit_course.php",
            type: "post",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === 'success') {
                    // Show a success message
                    showAlert('Course modified successfully!');

                    // Reload the courses
                    editCourse(e);
                } else {
                    // Show an error message
                    alert('An error occurred: ' + response.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Handle AJAX errors
                alert('AJAX error: ' + textStatus + ' : ' + errorThrown);
                console.log('AJAX error: ' + textStatus + ' : ' + errorThrown + '\n' + jqXHR.responseText);
            }
        });
    });

    $(document).on('submit', '#delete-course-form', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "../processes/delete_course.php",
            type: "post",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === 'success') {
                    // Show a success message
                    // alert('Course modified successfully!');
                    showAlert('Course deleted successfully!');

                    // Reload the courses
                    editCourse(e);
                } else {
                    // Show an error message
                    alert('An error occurred: ' + response.message);
                    console.log(response.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Handle AJAX errors
                alert('AJAX error: ' + textStatus + ' : ' + errorThrown);
                console.log('AJAX error: ' + textStatus + ' : ' + errorThrown + '\n' + jqXHR.responseText);
            }
        });
    });

    function editCourse(e) {
        e.preventDefault();
        $.ajax({
            url: "../processes/edit_course.php",
            type: "get",
            dataType: "json",
            success: function (response) {
                // Clear the container
                $(".admin-header-panel").html('');
                $(".courses-container").html('');

                // Create the course cards
                $('<h2></h2>').text('Edit Courses').appendTo('.admin-header-panel');
                $.each(response.courses, function (i, course) {
                    let courseBlock = $('<div class="course-block"></div>');
                    let form_container_1 = $('<div class="form-container_1 active"></div>').appendTo(courseBlock);
                    var form_delete = $('<form id="delete-course-form"></form>').appendTo(form_container_1);
                    $('<input type="hidden" name="CourseID" value="' + course.CourseID + '">').appendTo(form_delete);
                    $('<input type="submit" value="" id="delete-course-btn" class="delete-btn">').appendTo(form_delete);
                    form_delete.appendTo(form_container_1);
                    let img = $('<img alt="' + course.Title + '">').appendTo(form_container_1);
                    // Load the image asynchronously
                    $.get('../processes/image.php?table=Courses&id=' + course.CourseID, function (data) {
                        img.attr('src', data);
                    });
                    $('<h3></h3>').text(course.Title).appendTo(form_container_1);
                    $('<p></p>').text(course.Description).appendTo(form_container_1);
                    $('<p></p>').text('Level: ' + course.Level).appendTo(form_container_1);
                    $('<p></p>').text('Duration: ' + course.Duration + ' hours').appendTo(form_container_1);
                    $('<p></p>').text('Visible: ' + Boolean(course.Hide)).appendTo(form_container_1);
                    $('<a id="edit-course-btn" class="btn">Edit</a>').appendTo(form_container_1);

                    var form_container_2 = $('<div class="form_container_2"></div>').appendTo(courseBlock);
                    $('<div class="form-header"><h3 class="form-title">Edit Course</h3><a class="cancel-btn" id="cancel-btn-edit"></a></div>').appendTo(form_container_2);
                    // Create the form
                    var form = $('<form class="course-form" id="edit-course-form"></form>');
                    $('<input type="hidden" name="course-id" value="' + course.CourseID + '">').appendTo(form);
                    $('<label for="title">Title:</label>').appendTo(form);
                    $('<input type="text" id="title" name="title" value="' + course.Title + '" required>').appendTo(form);
                    $('<label for="level">Level:</label>').appendTo(form);
                    var select = $('<select id="level" name="level" required></select>').appendTo(form);
                    $('<option value="">Select a level</option>').appendTo(select);
                    $.each(response.levels, function (i, level) {
                        var option = $('<option value="' + level.Title + '">' + level.Title + '</option>');
                        if (level.Title === course.Level) {
                            option.attr('selected', 'selected');
                        }
                        option.appendTo(select);
                    });
                    $('<label for="description">Description:</label>').appendTo(form);
                    $('<textarea id="description" name="description" required>' + course.Description + '</textarea>').appendTo(form);
                    $('<label for="duration">Duration:</label>').appendTo(form);
                    $('<input type="number" id="duration" name="duration" value="' + course.Duration + '" required>').appendTo(form);
                    $('<label for="course-img">Choose an image:</label>').appendTo(form);
                    $('<input type="file" id="course-img" name="course-img" accept="image/*">').appendTo(form);
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

    function showAlert(message) {
        var alertBox = $('<div></div>').addClass('alert-message').text(message);
        $('body').append(alertBox);
        alertBox.fadeIn();
        setTimeout(function () {
            alertBox.fadeOut();
        }, 5000);
    }
});