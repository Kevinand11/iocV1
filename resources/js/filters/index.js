import Vue from "vue"

Vue.filter("myDate",function(date){
    return moment(date).format("MMMM Do YYYY")
})
Vue.filter("first100",function(text){
    return (text.length>100) ? text.slice(0,100) + "...." : text;
})
Vue.filter("addNairaSign",function(price){
    return "#" + price;
})