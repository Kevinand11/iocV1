const VuetifyLoader = require('vuetify-loader/lib/plugin');

module.exports = {
	configureWebpack: {
		plugins: [
			new VuetifyLoader(),
		]
	}
};
