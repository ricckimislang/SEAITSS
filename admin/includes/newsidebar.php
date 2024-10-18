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
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item link-nav">
            <a class="nav-link <?php echo isActive('newhome.php'); ?>" href="newhome.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link <?php echo isActive('new_create_form.php'); ?>" href="new_create_form.php">
                <i class="bi bi-card-text"></i>
                <span>Create Survey</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link <?php echo isActive('completed_survey.php'); ?>" href="completed_survey.php">
                <i class="bi bi-check2-square"></i>
                <span>Completed Survey</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link <?php echo isActive('logout.php'); ?>" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
            </a>
        </li><!-- End Dashboard Nav -->
    </ul>

</aside><!-- End Sidebar-->