<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            
            <li class="<?= $segment == 'admin_dashboard' ? 'active' : '' ?>">
                <a href="<?=asset('admin_dashboard?signup_stats_filter=daily&deactivation_stats_filter=daily')?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>

            </li>

            <li class="treeview <?= $segment == 'users_admin' || $segment == 'musicians_admin' ? 'menu-open' : '' ?>">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= $segment == 'users_admin' ? 'active' : '' ?>"><a href="<?= asset('users_admin')?>"><i class="fa fa-circle-o"></i> Users</a></li>
                    <li class="<?= $segment == 'musicians_admin' ? 'active' : '' ?>"><a href="<?= asset('musicians_admin')?>"><i class="fa fa-circle-o"></i> Musicians</a></li>
                </ul>
            </li>
            <li class="treeview <?= $segment == 'posts_admin' || $segment == 'reported_posts' ? 'menu-open' : '' || $segment == 'all_posts' ? 'menu-open' : '' ?>">
            <!--<li class="<?= $segment == 'posts_admin' ? 'active' : '' ?>" >-->
                <a href="<?= asset('#')?>">
                    <i class="fa fa-edit"></i> <span>Posts</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= $segment == 'posts_admin' ? 'active' : '' ?>"><a href="<?= asset('posts_admin')?>"><i class="fa fa-circle-o"></i> All Posts</a></li>
                    <li class="<?= $segment == 'reported_posts' ? 'active' : '' ?>"><a href="<?= asset('reported_posts')?>"><i class="fa fa-circle-o"></i> Reported Posts</a></li>
                </ul>
            </li>
            <li class="treeview <?= $segment == 'groups_admin' || $segment == 'reported_groups' ? 'menu-open' : '' || $segment == 'all_groups' ? 'menu-open' : '' ?>">
                <a href="<?= asset('#')?>">
                  <i class="fa fa-calendar" aria-hidden="true"></i><span>Events</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= $segment == 'groups_admin' ? 'active' : '' ?>"><a href="<?= asset('groups_admin')?>"><i class="fa fa-circle-o"></i> All Groups</a></li>
                    <li class="<?= $segment == 'reported_groups' ? 'active' : '' ?>"><a href="<?= asset('reported_groups')?>"><i class="fa fa-circle-o"></i> Reported Groups</a></li>
                </ul>
            </li>
            
<!--            <li class="<?= $segment == 'events_admin' ? 'active' : '' ?>">
                <a href="<?= asset('events_admin')?>">
                    <i class="fa fa-calendar"></i> <span>Events</span>
                </a>
            </li>-->
            
            <li class="<?= $segment == 'teaching_studios_admin' ? 'active' : '' ?>">
                <a href="<?= asset('teaching_studios_admin')?>">
                    <i class="fa fa-music"></i> <span>Teaching Studios</span>
                </a>
            </li>
            <li class="<?= $segment == 'accompanists_admin' ? 'active' : '' ?>">
                <a href="<?= asset('accompanists_admin')?>" class="accomp d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="21" viewBox="0 0 19 21" style="margin-right:5px;">
                            <path style="fill: #fff;" id="Forma_1" data-name="Forma 1" class="cls-1" d="M15.428,8.986a2.37,2.37,0,0,1-2.355-2.38A6.579,6.579,0,0,0,6.536,0,6.579,6.579,0,0,0,0,6.606V18.588a0.612,0.612,0,0,0,.609.615H3.557v1.182a0.609,0.609,0,1,0,1.217,0V19.2h9.452v1.182a0.609,0.609,0,1,0,1.217,0V19.2h2.948A0.612,0.612,0,0,0,19,18.588V12.6A3.6,3.6,0,0,0,15.428,8.986ZM3.556,17.972H1.217V14.41H3.354v1.182a0.82,0.82,0,0,0,.2.541v1.839h0Zm3.557,0H4.774V16.133a0.821,0.821,0,0,0,.2-0.541V14.41H6.91v1.182a0.82,0.82,0,0,0,.2.541v1.839Zm3.557,0H8.331V16.133a0.821,0.821,0,0,0,.2-0.541V14.41h1.933v1.182a0.82,0.82,0,0,0,.2.541v1.839Zm3.556,0H11.887V16.133a0.82,0.82,0,0,0,.2-0.541V14.41h1.933v1.182a0.821,0.821,0,0,0,.2.541v1.839h0ZM1.217,13.18V6.606A5.353,5.353,0,0,1,6.536,1.231a5.353,5.353,0,0,1,5.319,5.376,3.6,3.6,0,0,0,3.573,3.611,2.37,2.37,0,0,1,2.355,2.38V13.18H1.217Zm16.565,4.793H15.444V16.133a0.82,0.82,0,0,0,.2-0.541V14.41h2.136v3.562h0Z"></path>
                            </svg> <span>Accompanists</span>
                </a>
            </li>
            
            <li class="treeview <?= $segment == 'categories_admin' || $segment == 'add_category_admin' ? 'menu-open' : '' ?>">
                <a href="#">
                 <i class="fa fa-th-large" aria-hidden="true"></i>
                    <span>Categories</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= $segment == 'categories_admin' ? 'active' : '' ?>"><a href="<?= asset('categories_admin')?>"><i class="fa fa-circle-o"></i> Categories</a></li>
                    <li class="<?= $segment == 'add_category_admin' ? 'active' : '' ?>"><a href="<?= asset('add_category_admin')?>"><i class="fa fa-circle-o"></i> Add Category</a></li>
                </ul>
            </li>
            
            <li class="treeview <?= $segment == 'unions_admin' || $segment == 'add_union_admin' ? 'menu-open' : '' ?>">
                <a href="#">
                    <i class="fa fa-handshake-o" aria-hidden="true"></i>
                    <span>Unions</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= $segment == 'unions_admin' ? 'active' : '' ?>"><a href="<?= asset('unions_admin')?>"><i class="fa fa-circle-o"></i>All Unions</a></li>
                    <li class="<?= $segment == 'add_union_admin' ? 'active' : '' ?>"><a href="<?= asset('add_union_admin')?>"><i class="fa fa-circle-o"></i> Add Union</a></li>
                </ul>
            </li>
            
            <li class="treeview <?= $segment == 'interest_admin' || $segment == 'add_interest_admin' ? 'menu-open' : '' ?>">
                <a href="#">
                   <i class="fa fa-gratipay" aria-hidden="true"></i>
                    <span>Interests</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= $segment == 'interest_admin' ? 'active' : '' ?>"><a href="<?= asset('interest_admin')?>"><i class="fa fa-circle-o"></i>All Interests</a></li>
                    <li class="<?= $segment == 'add_interest_admin' ? 'active' : '' ?>"><a href="<?= asset('add_interest_admin')?>"><i class="fa fa-circle-o"></i> Add Interest</a></li>
                </ul>
            </li>
            
<!--            <li class="treeview <?= $segment == 'units_admin' || $segment == 'add_unit_admin' ? 'menu-open' : '' ?>">
                <a href="#">
                    <i class="fa fa-edit"></i>
                    <span>Unit</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= $segment == 'units_admin' ? 'active' : '' ?>"><a href="<?= asset('units_admin')?>"><i class="fa fa-circle-o"></i>All Units</a></li>
                    <li class="<?= $segment == 'add_unit_admin' ? 'active' : '' ?>"><a href="<?= asset('add_unit_admin')?>"><i class="fa fa-circle-o"></i> Add Unit</a></li>
                </ul>
           </li>-->
            
            <li class="<?= $segment == 'payments_admin' ? 'active' : '' ?>">
                <a href="<?= asset('payments_admin')?>">
                    <i class="fa fa-credit-card"></i> <span>Booking & Payments</span>
                </a>
            </li>
            
            <li class="<?= $segment == 'reviews_admin' ? 'active' : '' ?>">
                <a href="<?= asset('reviews_admin')?>">
                    <i class="fa fa-star-half-o" aria-hidden="true"></i> <span>Reviews</span>
                </a>
            </li>
            
            <li class="treeview <?= $segment == 'vulgar_terms_admin' || $segment == 'add_vulgar_terms_admin' ? 'menu-open' : '' ?>">
                <a href="#">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    <span>Vulgar Terms</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= $segment == 'vulgar_terms_admin' ? 'active' : '' ?>"><a href="<?= asset('vulgar_terms_admin')?>"><i class="fa fa-circle-o"></i> Vulgar Terms</a></li>
                    <li class="<?= $segment == 'add_vulgar_term_admin' ? 'active' : '' ?>"><a href="<?= asset('add_vulgar_term_admin')?>"><i class="fa fa-circle-o"></i> Add Vulgar Terms</a></li>
                </ul>
            </li>
            
            <li class="<?= $segment == 'change_password_admin' ? 'active' : '' ?>">
                <a href="<?= asset('change_password_admin')?>">
                    <i class="fa fa-lock"></i> <span>Change Password</span>
                </a>
            </li>
            <li class="treeview <?= $segment == 'admin_stats' || $segment == 'admin_booking_stats' ? 'menu-open' : '' ?>">
                <a href="#">
                    <i class="fa fa-bar-chart"></i>
                    <span>Statistics</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= $segment == 'admin_stats' ? 'active' : '' ?>"><a href="<?= asset('admin_stats')?>"><i class="fa fa-circle-o"></i>App Statistics</a></li>
                    <li class="<?= $segment == 'admin_booking_stats' ? 'active' : '' ?>"><a href="<?= asset('admin_booking_stats')?>"><i class="fa fa-circle-o"></i> Booking Statistics</a></li>
                </ul>
           </li>
            <li>
                <a href="<?= asset('logout_admin')?>">
                    <i class="fa fa-sign-out"></i> <span>Sign out</span>
                </a>
            </li>
            
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<script>
    $( document ).ready(function() {
        $('li.active').parent('.treeview-menu').toggle();
    });
</script>