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
            { path: '/', name: 'NewIn',component: NewIn, meta: { showCartFab:true } },
            { path: '/stores', name: 'Stores', component: Store, meta: { showCartFab:true } },
            { path: '/services', name: 'Services', component: Store, meta: { showCartFab:true } },
            { path: '/posts/', name: 'Posts', component: NewIn, meta: { showCartFab:true } },
            { path: '/posts/:id', name: 'Post', component: Post, meta: { showCartFab:true } },
        ], meta: { showCartFab:true }
    },
    { path: '/admin/developer', name: 'AdminDeveloper', component: Developer , meta: { requiresAuth:true, requiresAdmin: true }},
    { path: '/admin/users', name: 'AdminUsers', component: Users, meta: { requiresAuth:true, requiresAdmin: true } },
    { path: '/admin/stores', name: 'AdminStores', component: Stores, meta: { requiresAuth:true, requiresAdmin: true } },
    { path: '/admin/posts', name: 'AdminPosts', component: Posts, meta: { requiresAuth:true, requiresAdmin: true } },
    { path: '/admin/categories', name: 'AdminCategories', component: Categories, meta: { requiresAuth:true, requiresAdmin: true } },
    { path: '/store', name: 'MyStore', component: Store, meta: { requiresAuth:true } },
    { path: '/profile', name: 'Profile', component: Profile, meta: { requiresAuth:true } },
    { path: '/login', name: 'Login', component: Login, meta:{ isAuthRoute:true } },
    { path: '/register', name: 'Register', component: Register, meta:{ isAuthRoute:true } },
    { path: '*', name: 'NotFound', component: NotFound }
]

