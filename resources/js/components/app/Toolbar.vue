<template>
	<v-toolbar :color="appInfo.color" dark extended>
		<v-toolbar-side-icon  @click.stop="emitToggle" :class="{ 'hidden-sm-and-down': getModel || showLang }"></v-toolbar-side-icon>
		<v-list-tile-avatar :class="{ 'hidden-sm-and-down': getModel || showLang }">
			<img :src="getLogo | appendURL" alt="">
		</v-list-tile-avatar>
		<v-toolbar-title class="white--text ml-0" :class="{ 'hidden-sm-and-down': getModel || showLang }">{{ appInfo.name }}</v-toolbar-title>
		<v-spacer></v-spacer>
		<v-toolbar-items v-if="!getModel">
			<template v-if="showLang">
				<v-btn v-for="language in getLanguages" flat icon :key="language" @click="setLanguage(language)">
					<flag :iso="language" :squared="false"/>
				</v-btn>
			</template>
			<v-btn flat icon v-if="!showLang" @click="toggleShowLang">
				<flag :iso="getLocale" :squared="false"/>
			</v-btn>
			<v-btn flat icon @click="toggleModel">
				<v-icon>search</v-icon>
			</v-btn>
			<v-btn flat icon>
				<v-icon>more_vert</v-icon>
			</v-btn>
		</v-toolbar-items>
		<v-text-field hide-details v-model="search" prepend-icon="close" append-icon="search" single-line
			 v-if="getModel" @click:prepend="toggleModel" @click:append="searchIt" @click.prevent="searchIt"
			:placeholder="$t('toolbarSearchPlaceHolder')" @focusout="toggleModel" flat auotomplete="name"></v-text-field>
		<template slot="extension">
			<v-tabs :color="appInfo.color" centered dark grow hide-slider>
				<v-tab v-for="navLink in navLinks" :key="navLink.id" :to="navLink.route">{{ $t(`tab${navLink.name}`) }}</v-tab>
			</v-tabs>
		</template>
	</v-toolbar>
</template>

<script>
    import { mapGetters } from 'vuex';
    import i18n from '../../lang/index';

    export default {
        name: "Toolbar",
        data(){
            return {
            	model: false,
                search: "",
                navLinks:[
                    {id:1, name:'NewIn', icon:'new_releases', route:'/', color:"white"},
                    {id:2, name:'Stores', icon:'shop_two', route:'/stores', color:"white"},
                    {id:3, name:'Services', icon:'event', route:'/services', color:"white"},
                ],
				showLang: false,
            }
        },
        computed:{
            ...mapGetters(['appInfo','getLogo','getLanguages']),
			getModel(){ return this.model },
			getLocale(){ return i18n.locale },
        },
		methods:{
			emitToggle(){
				Fire.$emit("ToggleSidebar");
			},
        	toggleModel(){
        		this.model = !this.model;
				this.search = '';
			},
			toggleShowLang(){
				this.showLang = !this.showLang;
			},
			setLanguage(language){
				i18n.locale = language;
				this.toggleShowLang();
			},
			searchIt(){
        		if(this.search){
					console.log(this.search);
					this.search = '';
				}
			}
		}
    }
</script>
