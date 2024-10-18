<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<?php
function isActive($page)
{
    global $current_page;
    return ($current_page == $page) ? 'active' : '';
}
?>
<div class="col-md-2 mt-5">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" style="max-width: 100%;">
        <div class="text-center">
            <img src="../assets/image/logo.png" width="100" height="100" class="d-inline-block align-top" alt="">
        </div>
        <div class="sidebar-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php echo isActive('home.php'); ?>" href="home.php">
                        <span data-feather="home"></span>
                        Dashboard <?php if (isActive('home.php'))
                            echo '<span class="sr-only">(current)</span>'; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActive('create_form.php'); ?>" href="create_form.php">
                        <span data-feather="file"></span>
                        Create Survey
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActive('completed_surveys.php'); ?>" href="completed_surveys.php">
                        <span data-feather="list"></span>
                        Completed Survey
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActive('departments.php'); ?>" href="departments.php">
                        <span data-feather="list"></span>
                        Departments
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActive('logout.php'); ?>" href="logout.php">
                        <span data-feather="log-out"></span>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>