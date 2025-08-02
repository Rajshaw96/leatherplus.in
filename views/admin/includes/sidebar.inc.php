<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-edit"></i>
        </div>
        <div class="sidebar-brand-text mx-3">E-Com <sup>Admin</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<?= $url->baseUrl("admin/dashboard") ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <?php
    if ($_SESSION['admin_role'] == "admin" || $_SESSION['admin_role'] == "shopmanager") {
    ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts" aria-expanded="true" aria-controls="collapseProducts">
            <i class="fa fa-shopping-bag"></i>
            <span>Products</span>
        </a>
        <div id="collapseProducts" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $url->baseUrl("admin/products/add") ?>">Add New</a>
                <a class="collapse-item" href="<?= $url->baseUrl("admin/products/all") ?>">View All</a>
                <a class="collapse-item" href="<?= $url->baseUrl("admin/products/bulk-update") ?>">Bulk Update</a>
                <?php
                if ($_SESSION['admin_role'] == "admin") {
                ?>
                    <a class="collapse-item" href="<?= $url->baseUrl("admin/products/categories") ?>">Categories</a>
                    <a class="collapse-item" href="<?= $url->baseUrl("admin/products/attributes") ?>">Attributes</a>
                <?php
                }
                ?>
            </div>
        </div>
    </li>
    <?php  }  ?>

    <?php
    if ($_SESSION['admin_role'] == "admin" || $_SESSION['admin_role'] == "shopmanager") {
    ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBlogs" aria-expanded="true" aria-controls="collapseBlogs">
            <i class="fa fa-rss"></i>
            <span>Blogs</span>
        </a>
        <div id="collapseBlogs" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $url->baseUrl("admin/blogs/add") ?>">Add New</a>
                <a class="collapse-item" href="<?= $url->baseUrl("admin/blogs/all") ?>">View All</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= $url->baseUrl("admin/reviews/all") ?>">
            <i class="fas fa-fw fa-star"></i>
            <span>Reviews</span></a>
    </li>

    <?php  }  ?>

    <?php
    if ($_SESSION['admin_role'] == "admin" || $_SESSION['admin_role'] == "sales" || $_SESSION['admin_role'] == "shopmanager") {
    ?>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrders" aria-expanded="true" aria-controls="collapseOrders">
                <i class="fa fa-gift"></i>
                <span>Orders</span>
            </a>
            <div id="collapseOrders" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= $url->baseUrl("admin/orders/all") ?>">View All</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
                <i class="fa fa-users"></i>
                <span>Users</span>
            </a>
            <div id="collapseUsers" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= $url->baseUrl("admin/users/add") ?>">Add New</a>
                    <a class="collapse-item" href="<?= $url->baseUrl("admin/users/all") ?>">View All</a>
                </div>
            </div>
        </li>

    <?php  }  ?>

    <?php
    if ($_SESSION['admin_role'] == "admin") {
    ?>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings">
                <i class="fa fa-cog"></i>
                <span>Settings</span>
            </a>
            <div id="collapseSettings" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= $url->baseUrl("admin/settings/taxes") ?>">Taxes</a>
                    <a class="collapse-item" href="<?= $url->baseUrl("admin/settings/notifications") ?>">Notifications</a>
                </div>
            </div>
        </li>

    <?php  }  ?>

    <?php
    if ($_SESSION['admin_role'] == "admin" || $_SESSION['admin_role'] == "shopmanager") {
    ?>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAppearance" aria-expanded="true" aria-controls="collapseAppearance">
            <i class="fa fa-brush"></i>
            <span>Appearance</span>
        </a>
        <div id="collapseAppearance" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $url->baseUrl("admin/appearance/homepage-slider") ?>">Homepage Slider</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fa fa-file"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $url->baseUrl("admin/pages/company-profile") ?>">Company Profile</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseJobOpenings" aria-expanded="true" aria-controls="collapseJobOpenings">
            <i class="fa fa-briefcase"></i>
            <span>Job Openings</span>
        </a>
        <div id="collapseJobOpenings" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $url->baseUrl("admin/job-openings/add") ?>">Add</a>
                <a class="collapse-item" href="<?= $url->baseUrl("admin/job-openings/all") ?>">All</a>
            </div>
        </div>
    </li>

    <?php } ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->