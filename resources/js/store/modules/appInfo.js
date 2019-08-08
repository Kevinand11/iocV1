const state = {
    app: {
        name: "IOCMart",
		color: 'light-blue darken-4',
		sidebar_width: '250',
		url: window.location.origin+'/',
    },
	logo: "images/logo.png",
	profile: "images/profile.png",
	storeLogo: "images/store.png",
	languages:[
		'us', 'es', 'ng'
	]
};

const getters = {
    appInfo: state => state.app,
	getLogo: state => state.logo,
	getProfile: state => state.profile,
	getStoreLogo: state => state.storeLogo,
	getLanguages: state => state.languages,
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
