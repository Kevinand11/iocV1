import Dashboard from "../views/dashboard/index.vue";
import NewIn from "../views/dashboard/NewIn.vue";
import Post from "../views/dashboard/Post.vue";

import Store from "../views/user/Store.vue";
import Profile from "../views/user/Profile.vue";

import Users from "../views/admin/Users.vue";
import Stores from "../views/admin/Stores.vue";
import Posts from "../views/admin/Posts.vue";
import Categories from "../views/admin/Categories.vue";
import Developer from "../views/admin/Developer.vue";

import Login from "../views/auth/Login.vue";
import Register from "../views/auth/Register.vue";

import NotFound from "../views/NotFound.vue";

export default [
    { path: '/', component: Dashboard, children: [
            { path: '/', name: 'NewIn',component: NewIn },
            { path: '/stores', name: 'Stores', component: Store },
            { path: '/services', name: 'Services', component: Store },
            { path: '/posts/', name: 'Posts', component: NewIn },
            { path: '/posts/:id', name: 'Post', component: Post },
        ]
    },
    { path: '/admin/developer', name: 'AdminDeveloper', component: Developer },
    { path: '/admin/users', name: 'AdminUsers', component: Users },
    { path: '/admin/stores', name: 'AdminStores', component: Stores },
    { path: '/admin/posts', name: 'AdminPosts', component: Posts },
    { path: '/admin/categories', name: 'AdminCategories', component: Categories },
    { path: '/store', name: 'MyStore', component: Store },
    { path: '/profile', name: 'Profile', component: Profile },
    { path: '/login', name: 'Login', component: Login },
    { path: '/register', name: 'Register', component: Register },
    { path: '*', name: 'NotFound', component: NotFound }
]

