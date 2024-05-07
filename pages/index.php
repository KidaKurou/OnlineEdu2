<html>
<head>
    <title>Course Website</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h2>Welcome to Our Course Website</h2>
        <p>Here you can find a variety of courses to suit your learning needs.</p>
    </div>

    <div class="sort">
        <label for="order">Sort by:</label>
        <select id="order" name="order">
            <option value="level">Level</option>
            <option value="alphabetical">Alphabetical</option>
        </select>
    </div>

    <div class="courses-container"></div>

    <?php include 'footer.php'; ?>

    <script>
        $(document).ready(function() {
            // Function to fetch and display the courses
            function fetchCourses() {
                var order = $('#order').val();
                $('.courses-container').load('../processes/fetch_courses.php?order=' + order);
            }

            // Fetch and display the courses when the page loads
            fetchCourses();

            // Fetch and display the courses when the sorting order is changed
            $('#order').change(fetchCourses);
        });
    </script>
</body>
</html>