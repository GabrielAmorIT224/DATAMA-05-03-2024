<?php
include 'database_user.php';
session_start(); // Start the session

if (!isset($_SESSION["user_id"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login_user.php");
    exit();
}

// Fetch the user's information from the database
$user_id = $_SESSION["user_id"];
$sqlUser = "SELECT * FROM tbl_user WHERE USER_ID = ?";
$stmtUser = mysqli_stmt_init($conn);

if (mysqli_stmt_prepare($stmtUser, $sqlUser)) {
    mysqli_stmt_bind_param($stmtUser, "i", $user_id);
    mysqli_stmt_execute($stmtUser);
    $resultUser = mysqli_stmt_get_result($stmtUser);

    if ($row = mysqli_fetch_assoc($resultUser)) {
        $first_name = $row["FIRST_NAME"];
        $middle_name = $row["MIDDLE_NAME"];
        $last_name = $row["LAST_NAME"];
        $dob = $row["DOB"];
        $city = $row["CITY"];
        $barangay = $row["BARANGAY"];
        $street = $row["STREET"];
        $email = $row["EMAIL_ADD"];
        $contact_no = $row["CONTACT_NO"];
        // Add other fields as needed
    }

    // Close the statement
    mysqli_stmt_close($stmtUser);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="user_information.css">
    <title>Settings</title>
</head>
<body>

<div class="header">
    <div class="header-content">
        <?php if (isset($first_name)) : ?>
            <h1><?php echo $first_name; ?>'s Settings</h1>
        <?php else : ?>
            <h1>Welcome to User Dashboard</h1>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <?php
    if (isset($_POST["submit"])) {
        // Your validation and updating logic goes here

        // Example: Update the user's information based on form data
        $newFirstName = $_POST["FirstName"];
        $newMiddleName = $_POST["MiddleName"];
        $newLastName = $_POST["LastName"];
        $newDOB = date("Y-m-d", strtotime($_POST["DateOfBirth"]));
        $newCity = $_POST["City"];
        $newBarangay = $_POST["Barangay"];
        $newStreet = $_POST["Street"];
        $newEmail = $_POST["Email"];
        $newContactNo = $_POST["ContactNo"];
        // Add other fields as needed

        $sqlUpdateUser = "UPDATE tbl_user SET FIRST_NAME = ?, MIDDLE_NAME = ?, LAST_NAME = ?, DOB = ?, CITY = ?, BARANGAY = ?, STREET = ?, EMAIL_ADD = ?, CONTACT_NO = ? WHERE USER_ID = ?";
        $stmtUpdateUser = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmtUpdateUser, $sqlUpdateUser)) {
            mysqli_stmt_bind_param($stmtUpdateUser, "sssssssssi", $newFirstName, $newMiddleName, $newLastName, $newDOB, $newCity, $newBarangay, $newStreet, $newEmail, $newContactNo, $user_id);
            mysqli_stmt_execute($stmtUpdateUser);
            echo "<div class='alert alert-success'>User information updated successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error preparing update statement.</div>";
        }

        mysqli_stmt_close($stmtUpdateUser);
    }
    ?>

    <form action="user_information.php" method="post">
        <h4>Update your Personal Information</h4>

        <div class="form-group">
            <label for="FirstName">First Name:</label>
            <input type="text" class="form-control" name="FirstName" id="FirstName" placeholder="First Name: " value="<?php echo $first_name; ?>">
        </div>
        <div class="form-group">
            <label for="MiddleName">Middle Name:</label>
            <input type="text" class="form-control" name="MiddleName" id="MiddleName" placeholder="Middle Name: " value="<?php echo $middle_name; ?>">
        </div>
        <div class="form-group">
            <label for="LastName">Last Name:</label>
            <input type="text" class="form-control" name="LastName" id="LastName" placeholder="Last Name: " value="<?php echo $last_name; ?>">
        </div>
        <label for="DateOfBirth">Enter Date of Birth:</label>
        <div class="form-group">
            <input type="date" class="form-control" name="DateOfBirth" id="DateOfBirth" placeholder="Date of Birth: " value="<?php echo $dob; ?>">
        </div>
        <div class="form-group">
            <label for="City">City:</label>
            <input type="text" class="form-control" name="City" id="City" placeholder="City: " value="<?php echo $city; ?>">
        </div>
        <div class="form-group">
            <label for="Barangay">Barangay:</label>
            <input type="text" class="form-control" name="Barangay" id="Barangay" placeholder="Barangay: " value="<?php echo $barangay; ?>">
        </div>
        <div class="form-group">
            <label for="Street">Street:</label>
            <input type="text" class="form-control" name="Street" id="Street" placeholder="Street: " value="<?php echo $street; ?>">
        </div>
        <div class="form-group">
            <label for="Email">Email:</label>
            <input type="text" class="form-control" name="Email" id="Email" placeholder="Email: " value="<?php echo $email; ?>">
        </div>
        <div class="form-group">
            <label for="ContactNo">Contact No:</label>
            <input type="int" class="form-control" name="ContactNo" id="ContactNo" placeholder="Contact No: " value="<?php echo $contact_no; ?>">
        </div>
        <!-- Add other form fields as needed -->

        <div class="form-group">
            <input type="submit" class="btn btn-primary key" name="submit" value="Update">
        </div>
    </form>
</div>

</body>
</html>
