CREATE DATABASE OnlineCSchool;

USE OnlineCSchool;

CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Email VARCHAR(100) UNIQUE,
    Login VARCHAR(50),
    Password VARCHAR(50),
    Level ENUM('Beginner', 'Junior', 'Middle', 'Senior') DEFAULT 'Beginner'
);

CREATE TABLE Courses (
    CourseID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(100),
    Picture BLOB,
    Level ENUM('Junior', 'Middle', 'Senior'),
    Description TEXT,
    Duration INT
);

CREATE TABLE UserCourses (
    UserID INT,
    CourseID INT,
    Status ENUM('In Progress', 'Completed'),
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (CourseID) REFERENCES Courses(CourseID),
    PRIMARY KEY (UserID, CourseID)
);

INSERT INTO Users (FirstName, LastName, Email, Login, Password)
VALUES ('John', 'Doe', 'john.doe@example.com', 'johndoe', 'password123'),
       ('Jane', 'Doe', 'jane.doe@example.com', 'janedoe', 'password123');

INSERT INTO Courses (Title, Picture, Level, Description, Duration)
VALUES ('C# for Beginners', NULL, 'Junior', 'Learn the basics of C# programming.', 30),
	   ('C# for Middle', NULL, 'Middle', 'Learn the middle of C# programming.', 60),
       ('Advanced C#', NULL, 'Senior', 'Master the advanced concepts of C# programming.', 120);

INSERT INTO UserCourses (UserID, CourseID, Status)
VALUES (1, 1, 'Completed'),
	   (1, 2, 'In Progress'),
       (2, 1, 'Completed'),
       (2, 2, 'Completed'),
       (2, 3, 'In Progress');


INSERT INTO Courses (Title, Picture, Level, Description, Duration)
VALUES ('PHP for Beginners', NULL, 'Junior', 'Learn the basics of PHP programming. Learn the basics of PHP programming. Learn the basics of PHP programming. Learn the basics of PHP programming. Learn the basics of PHP programming. Learn the basics of PHP programming. Learn the basics of PHP programming. Learn the basics of PHP programming. Learn the basics of PHP programming. Learn the basics of PHP programming. Learn the basics of PHP programming.', 30),
	   ('PHP for Middle', NULL, 'Middle', 'Learn the middle of PHP programming. Learn the middle of PHP programming. Learn the middle of PHP programming. Learn the middle of PHP programming. Learn the middle of PHP programming. Learn the middle of PHP programming. Learn the middle of PHP programming. Learn the middle of PHP programming. Learn the middle of PHP programming. Learn the middle of PHP programming. Learn the middle of PHP programming.', 60),
       ('Advanced PHP', NULL, 'Senior', 'Master the advanced concepts of PHP programming. Master the advanced concepts of PHP programming. Master the advanced concepts of PHP programming. Master the advanced concepts of PHP programming. Master the advanced concepts of PHP programming. Master the advanced concepts of PHP programming. Master the advanced concepts of PHP programming. Master the advanced concepts of PHP programming. Master the advanced concepts of PHP programming.', 120);