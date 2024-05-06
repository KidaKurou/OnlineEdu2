<div class="course-block">
    <img src="../processes/image.php?id=<?php echo $row['CourseID']; ?>" alt="<?php echo $row['Title']; ?>">
    <h2><?php echo $row['Title']; ?></h2>
    <p>Level: <?php echo $row['Level']; ?></p>
    <a href="course.php?id=<?php echo $row['CourseID']; ?>" class="btn">More</a>
</div>
