<<template>
    <div>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index3.html" class="brand-link">
                <img src="../img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">IOCMart</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="../img/profile.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">
                        Username
                        <p>User Type</p>
                    </a>
                </div>
                </div>
                <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <router-link to="/master/" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt text-blue"></i>
                            <b>Dashboard</b>
                        </router-link>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-cog text-success"></i>
                            <p>
                            <i class="right fa fa-angle-left"></i>
                            <b>Management</b>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link to="/master/users" class="nav-link">
                                    <i class="fas fa-users nav-icon text-yellow"></i>
                                    <b>Users</b>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/master/posts" class="nav-link">
                                    <i class="fas fa-shopping-cart nav-icon text-indigo"></i>
                                    <b>Posts</b>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/master/categories" class="nav-link">
                                    <i class="fas fa-list nav-icon text-teal"></i>
                                    <b>Categories</b>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <router-link to="/master/developer" class="nav-link">
                            <i class="nav-icon fas fa-cogs text-orange"></i>
                            <b>Developer</b>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/master/profile" class="nav-link">
                            <i class="nav-icon fas fa-user text-cyan"></i>
                            <b>Profile</b>
                        </router-link>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/logout" onclick="event.preventDefault(); document.getElementById('logout').submit();">
                        <i class="nav-icon fa fa-power-off text-red"></i>
                        <b>Logout</b>
                    </a>
                    <form id="logout" action="/logout" method="POST" style="display: none;">
                        @csrf
                    </form>
                    </li>
                </ul>
                </nav>
            </div>
        </aside>
    </div>
</template>

<<script>
    export default {
        name:"Panel"
    }
</script>