<?php
    @include('../../conn.php');
    function sanitize_input($data)
    {
        return htmlspecialchars(strip_tags(trim($data)));
    }
    
    // Function to display a styled message
    function displayMessage($message, $type = 'success') {
        $style = $type === 'success' ? 
            'background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; border: 1px solid #c3e6cb; margin-bottom: 15px;' : 
            'background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; border: 1px solid #f5c6cb; margin-bottom: 15px;';
        
        echo "<div style='$style'>$message</div>";
    }

    // Check if the form is submitted
    if (isset($_POST['sub'])) {
        // Personal Information
        $firstName = sanitize_input($_POST['fname']);
        $middleName = sanitize_input($_POST['mname']);
        $lastName = sanitize_input($_POST['lname']);
        $dob = sanitize_input($_POST['dob']);
        $maritalStatus = sanitize_input($_POST['marital-status']);

        // Contact Information
        $email = sanitize_input($_POST['email']);
        $phone = sanitize_input($_POST['phone']);

        // Address Information
        $address = sanitize_input($_POST['address']);
        $city = sanitize_input($_POST['city']);
        $state = sanitize_input($_POST['state']);
        $zip = sanitize_input($_POST['zip']);
        $country = sanitize_input($_POST['country']);

        // Login Information
        $username = sanitize_input($_POST['username']);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        // Generate random ID for the user
        $randomString = strtoupper(bin2hex(random_bytes(3)));
        $randomNum = rand(100, 999);
        $userId = "ADMIN" . $randomNum . $randomString;

        // File Upload Validation
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageName = $_FILES['image']['name'];
            $imageTempName = $_FILES['image']['tmp_name'];
            $upload_dir = 'userimages/' . $imageName;

            if (!move_uploaded_file($imageTempName, $upload_dir)) {
                displayMessage("Failed to upload image.", 'error');
                exit;
            }
        } else {
            displayMessage("Image upload failed with error code " . $_FILES['image']['error'], 'error');
            exit;
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            displayMessage("Invalid email format", 'error');
            exit;
        }

        // Validate phone number
        if (!ctype_digit($phone) || strlen($phone) < 7) {
            displayMessage("Invalid phone number", 'error');
            exit;
        }

        // Check if password and confirm password match
        if ($password !== $confirmPassword) {
            displayMessage("Passwords do not match!", 'error');
            exit;
        }

        // Hash the password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        mysqli_begin_transaction($conn);
        try {
            // User table insert
            $userQuery = "INSERT INTO users (userId,username,email,password,createdAt,userType)
                                         values('$userId','$username','$email','$hashedPassword',NOW(),'Admin')";
            $userResult = mysqli_query($conn, $userQuery);

            if (!$userResult) {
                throw new Exception("User query failed: " . mysqli_error($conn));
            }

            // Personal information table insert
            $personalQuery = "INSERT INTO personal_information(
                                              user_id,
                                              first_name,
                                              middle_name,
                                              last_name,
                                              dob,
                                              marital_status,
                                              phone_number,
                                              image,
                                              mail)
                                         values(
                                              '$userId',
                                              '$firstName',
                                              '$middleName',
                                              '$lastName',
                                              '$dob',
                                              '$maritalStatus',
                                              '$phone',
                                              '$imageName',
                                              '$email')";
            $personalResult = mysqli_query($conn, $personalQuery);

            if (!$personalResult) {
                throw new Exception("Personal information query failed: " . mysqli_error($conn));
            }

            // Address table insert
            $addressSql = "INSERT INTO address (user_id, street, city, state, country, zip_code)
                                         values('$userId','$address','$city','$state','$country','$zip')";
            $addressResult = mysqli_query($conn, $addressSql);

            if (!$addressResult) {
                throw new Exception("Address query failed: " . mysqli_error($conn));
            }

            // If all queries succeed, commit the transaction
            if ($userResult && $personalResult && $addressResult) {
                mysqli_commit($conn);
                displayMessage("User successfully registered", 'success');
            }
        } catch (Exception $e) {
            mysqli_rollback($conn);
            displayMessage("Error: " . $e->getMessage(), 'error');
        }
    }
?>
