<template>
	<v-btn fab :color="appInfo.color" bottom right fixed @click="cartFab" v-if="shouldShow">
		<v-icon color="white">shopping_cart</v-icon>
	</v-btn>
</template>

<script>
	import { mapGetters } from "vuex";

	export default {
		name: 'FloatingButton',
		computed:{
			...mapGetters(['isLoggedIn','appInfo']),
			shouldShow(){ return this.$route.meta.showCartFab },
		},
		methods: {
			cartFab(){
				console.log("Going To Cart!");
			},
		}
	}
</script>
