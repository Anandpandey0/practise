<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
        <a class="navbar-brand" href="/practise/index.php">
            <img src="https://placeholder.pics/svg/150x50/888888/EEE/Logo" alt="..." height="36">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/practise/index.php">Home</a>
                </li>
                <?php if ($role === 'admin') : ?>
                    <!-- Display "My Databases" for admin -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            My Databases
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/practise/admin_portal.php">Booked Cars DB</a></li>
                            <li><a class="dropdown-item" href="/practise/cars_db.php">Cars DB</a></li>

                        </ul>
                    </li>
                <?php else : ?>
                    <!-- Display "My bookings" for user -->
                    <li class="nav-item">
                        <a class="nav-link" href="/practise/my_booking.php">My bookings</a>
                    </li>
                <?php endif; ?>
                <?php if (!isset($_SESSION['user'])) : ?>
                    <!-- Display login options for admin or user when not logged in -->
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Login As
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/practise/login.php">Customer</a></li>
                        <li><a class="dropdown-item" href="/practise/admin_login.php">Admin</a></li>
                    </ul>
                    </li>
                <?php endif; ?>
                <li class="nav-item ">
                    <a class="nav-link " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if (isset($_SESSION['user'])) : ?>
                            Welcome, <?php echo $name; ?> <!-- Display the user's name here -->
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <?php if (isset($_SESSION['user'])) : ?>
                            <li>
                                <form method="post" action="">
                                    <button type="submit" class="dropdown-item" name="logout">Logout</button>
                                </form>
                            </li>
                            <?php if ($role === 'admin') : ?>
                                <hr>
                                <li class="text-center">
                                    <a href="/practise/new_admin.php" class="text-decoration-none text-black ">Add New Admin</a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>