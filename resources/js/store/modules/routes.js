const state = {
    auth:{
        profile: '/api/v1/auth/profile',
		update: '/api/v1/auth/update',
		updateStore: '/api/v1/auth/updateStore',
        login:"/api/v1/auth/login",
        register:"/api/v1/auth/register",
        logout:"/api/v1/auth/logout",
    },
    users:{
        index:"/api/v1/users",
        paginate:"/api/v1/users/paginate?page=",
        store:"/api/v1/users/",
        show:"/api/v1/users/",
        update:"/api/v1/users/",
        delete:"/api/v1/users/"
    },
    stores:{
        index:"/api/v1/stores",
        paginate:"/api/v1/stores/paginate?page=",
        store:"/api/v1/stores/",
        show:"/api/v1/stores/",
        update:"/api/v1/stores/",
        delete:"/api/v1/stores/"
    },
    posts:{
        index:"/api/v1/posts",
        paginate:"/api/v1/posts/paginate?page=",
        store:"/api/v1/posts/",
        show:"/api/v1/posts/",
        update:"/api/v1/posts/",
        delete:"/api/v1/posts/"
    },
    categories:{
        index:"/api/v1/categories",
        paginate:"/api/v1/categories/paginate?page=",
        store:"/api/v1/categories/",
        show:"/api/v1/categories/",
        update:"/api/v1/categories/",
        delete:"/api/v1/categories/"
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
