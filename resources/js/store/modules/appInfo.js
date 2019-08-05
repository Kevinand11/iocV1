const state = {
    app: {
        name: "IOCMart",
		color: 'light-blue darken-4',
		sidebar_width: '250',
		url: 'http://localhost:8000/',
    },
	logo: "images/logo.png",
	profile: "images/profile.png",
	storeLogo: "images/store.png",
};

const getters = {
    appInfo: state => state.app,
	getLogo: state => state.logo,
	getProfile: state => state.profile,
	getStoreLogo: state => state.storeLogo,
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
