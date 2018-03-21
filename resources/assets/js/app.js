
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});



$(window).scroll(function() {
    var sc = $(window).scrollTop();
    if(sc > 400){
        $(".back-to-top").css("display","block");
    }else{
        $(".back-to-top").css("display","none");
    }
});

$(".back-to-top").click(function() {
    var sc = $(window).scrollTop();
    $('body, html').animate({scrollTop:0}, 500);
});

$(function () {
    $('[data-toggle="popover"]').popover()
});

$('#avatarFile').change(function () {
    var fileObj = document.getElementById('avatarFile').files[0];
    if (fileObj) {
        var type = fileObj.name.substr(fileObj.name.lastIndexOf('.'));

        var theImage = new Image();
        theImage.src = fileObj;
        var imageWidth = theImage.width;
        var imageHeight = theImage.height;

        if (type != '.jpg' && type != '.jpeg' && type != '.png')
            alert ('只支持 JPG/JPEG/PNG 图片格式');
        else if (fileObj.size > 2*1024*1024)
            alert('文件大小不能超过2M');
        else if (imageWidth < 200 || imageHeight < 200)
            alert('图片宽高必须 200px 以上');
        else
            $('#avatarSubmit').click();
    }
});