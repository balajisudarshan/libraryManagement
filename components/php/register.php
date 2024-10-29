<?php
@include('../../conn.php');
function sanitize_input($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

// Check if the form is submitted
if (isset($_POST['sub'])) {
    // Personal Information
    $firstName = sanitize_input($_POST['fname']);             // First Name
    $middleName = sanitize_input($_POST['mname']);            // Middle Name
    $lastName = sanitize_input($_POST['lname']);              // Last Name
    $dob = sanitize_input($_POST['dob']);                     // Date of Birth
    $maritalStatus = sanitize_input($_POST['marital-status']); // Marital Status

    // Contact Information
    $email = sanitize_input($_POST['email']);                 // Email
    $phone = sanitize_input($_POST['phone']);                 // Phone Number

    // Address Information
    $address = sanitize_input($_POST['address']);             // Street Address
    $city = sanitize_input($_POST['city']);                   // City
    $state = sanitize_input($_POST['state']);                 // State / Province
    $zip = sanitize_input($_POST['zip']);                     // ZIP Code
    $country = sanitize_input($_POST['country']);             // Country

    // Login Information
    $username = sanitize_input($_POST['username']);           // Username
    $password = $_POST['password'];                           // Password (not sanitized yet, as we hash it first)
    $confirmPassword = $_POST['confirmPassword'];

    $randomString = strtoupper(bin2hex(random_bytes(3)));
    $randomNum = rand(100, 999);


    $userId = "USER" . $randomNum . $randomString;// Confirm Password


    $imageName = $_FILES['image']['name'];
    $imageTempName = $_FILES['image']['tmp_name'];
    $upload_dir = 'userimages/'.$imageName;

   

    move_uploaded_file($imageTempName,$upload_dir);


    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Validate phone number (basic validation assuming numeric input)
    if (!ctype_digit($phone) || strlen($phone) < 7) {
        die("Invalid phone number");
    }

    // Check if password and confirm password match
    if ($password !== $confirmPassword) {
        die("Passwords do not match!");
    }

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    mysqli_begin_transaction($conn);
    try {
        $userQuery = "INSERT INTO users (userId,username,email,password,createdAt,image)
                                      values(
                                        '$userId',
                                        '$username',
                                        '$email',
                                        '$hashedPassword',
                                        NOW(),
                                        '$imageName'
                                      )";
        $userResult = mysqli_query($conn, $userQuery);
        mysqli_commit($conn);
        echo "User Succesfully registerd";
    } catch (EXCEPTION $e) {
        mysqli_rollback($conn);
        echo "Error " . $e->getMessage();

    }

}
?>