import Vue from "vue"
import VuexStore from "../store";

Vue.filter("myDate",function(date){
	let months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec'];
	let theDate = new Date(date);
	return months[theDate.getMonth()] + ' ' + theDate.getDate() + ', ' + theDate.getFullYear();
});
Vue.filter("first100",function(text){
    return (text.length>100) ? text.slice(0,100) + "...." : text;
});
Vue.filter("addNairaSign",function(price){
    return "#" + price;
});
Vue.filter("appendURL",function(picture){
	let url = VuexStore.getters.appInfo.url;
	return url + picture;
});
