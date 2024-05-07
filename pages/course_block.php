<div class="course-block">
    <img src="../processes/image2.php?table=Courses&id=<?php echo $row['CourseID']; ?>" alt="<?php echo $row['Title']; ?>">
    <h2><?php echo $row['Title']; ?></h2>
    <p>Level: <?php echo $row['Level']; ?></p>
    <a href="course.php?id=<?php echo $row['CourseID']; ?>" class="btn">More</a>
</div>

<!-- <script>
    console.log($('course-block.img').attr('src'));
    // Load the image asynchronously
    $.get($('course-block').find('img').attr('src'), function(data) {
        img.attr('src', data);
    });
</script> -->