const state = {
    auth:{
        login:"/api/users/login",
        register:"/api/users/register",
        logout:"/api/users/logout",
        profile: '/api/users/profile'
    },
    users:{
        index:"/api/users",
        paginate:"/api/users/paginate?page=",
        store:"/api/users/",
        show:"/api/users/",
        update:"/api/users/",
        delete:"/api/users/"
    },
    stores:{
        index:"/api/stores",
        paginate:"/api/stores/paginate?page=",
        store:"/api/stores/",
        show:"/api/stores/",
        update:"/api/stores/",
        delete:"/api/stores/"
    },
    posts:{
        index:"/api/posts",
        paginate:"/api/posts/paginate?page=",
        store:"/api/posts/",
        show:"/api/posts/",
        update:"/api/posts/",
        delete:"/api/posts/"
    },
    categories:{
        index:"/api/categories",
        paginate:"/api/categories/paginate?page=",
        store:"/api/categories/",
        show:"/api/categories/",
        update:"/api/categories/",
        delete:"/api/categories/"
    },
};

const getters = {
    authRoutes: state => state.auth,
    usersRoutes: state => state.users,
    storesRoutes: state => state.stores,
    postsRoutes: state => state.posts,
    categoriesRoutes: state => state.categories,
};

const actions = {
};

const mutations = {
};

export default {
    state,
    getters,
    actions,
    mutations
};
