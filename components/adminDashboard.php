<?php
    $username = $_GET['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sidebar</title>
    <link rel="stylesheet" href="internalStyle/adminDashboard.css"> <!-- Link to external CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
   
    <div class="sidebar">
    <div class="logo">
        <img src="logo.png" alt="Logo">
    </div>
    <div class="menu-toggle">
        <i class="fas fa-bars"></i> <!-- Hamburger icon -->
    </div>
    <ul class="nav-links">
        <li><i class="fas fa-tachometer-alt"></i><span> Dashboard</span></li>
        <li><i class="fas fa-book"></i><span> View Books</span></li>
        <li><i class="fas fa-plus-circle"></i><span> Add Books</span></li>
        <li><i class="fas fa-search"></i><span> Search Books</span></li>
        <li><i class="fas fa-users"></i><span> Add User</span></li>
        <li><i class="fas fa-book-reader"></i><span> Borrowed Books</span></li>
        <li><i class="fa-solid fa-right-from-bracket"></i><span> Logout </span></li>
    </ul>
    </div>

    <section class="hero">
    <center>
        <h1>Welcome <span><?php echo ucfirst($username); ?></span></h1>
    </center>

    <div class="cards-container">
        <!-- Total Books Card -->
        <div class="card card-books" aria-label="Total Books">
            <i class="fas fa-book card-icon"></i> <!-- Font Awesome book icon -->
            <h2>Total Books</h2>
            <p><?php echo isset($totalBooks) ? $totalBooks : 'N/A'; ?></p>
        </div>

        <!-- Total Users Card -->
        <div class="card card-users" aria-label="Total Users">
            <i class="fas fa-users card-icon"></i> <!-- Font Awesome users icon -->
            <h2>Total Users</h2>
            <p><?php echo isset($totalUsers) ? $totalUsers : 'N/A'; ?></p>
        </div>

        <!-- Total Genres Card -->
        <div class="card card-genres" aria-label="Total Genres">
            <i class="fas fa-list card-icon"></i> <!-- Font Awesome list icon -->
            <h2>Total Genres</h2>
            <p><?php echo isset($totalGenres) ? $totalGenres : 'N/A'; ?></p>
        </div>
    </div>
</section>




    
   

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
