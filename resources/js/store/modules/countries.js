import names from './names';

const state = {
	countries: names,
	defaultCountry: 'NG'
};

const getters = {
	getCountries: state => state.countries,
	getDefaultCountry: state => state.defaultCountry,
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
