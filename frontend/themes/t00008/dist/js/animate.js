/**
 * Created by gohoc on 2017/4/11.
 */

$(window).ready(function(){

    var winHeight = $(window).height();
    var winScrollHeight = $(window).scrollTop();


    var objectBanner = $('.banner-animate-wrap ');
    var objectServerCase = $('.severRange-swipe-case ');
    var objectServerText = $('.severRange-swipe-content ');
    var objectPro_title = $('.home-product-title');
    var objectPro_describe = $('.home-product-describe');
    var objectData_form = $('.data-box-form');
    var objectData_describe = $('.data-box-describe');
    var objectOpacity_content = $('.opacity-content');
    var objectOpacity_btn = $('.opacity-btn');
    var objectNews_row = $('.home-news-row');

    var objectAbout = $('.home-about-content');


    function scrollDisplay( objectName,className){
        winScrollHeight = $(window).scrollTop();
        var obj_offset=objectName.offset();
        if(obj_offset){
        	if( objectName.offset().top < (winScrollHeight + winHeight)){
            objectName.addClass(className);
        	}
        }
        // console.log("a:"+objectName.offset().top);
        // console.log("b:"+winHeight);
        // console.log("c:"+(winScrollHeight + winHeight));      
    }



    //init

    //objectBanner
    scrollDisplay(objectBanner,'effect_DownFade');
    //objectServerCase
    scrollDisplay(objectServerCase,'effect_Rotate180');
    //objectServerText
    scrollDisplay(objectServerText,'effect_leftGood');
    //objectAbout
    scrollDisplay(objectPro_title,'effect_right');
    //objectAbout
    scrollDisplay(objectPro_describe,'effect_li_right');
    //objectData
    scrollDisplay(objectData_form,'effect_Down');
    //objectData_describe
    scrollDisplay(objectData_describe,'effect_Up');
    //objectOpacity_content
    scrollDisplay(objectOpacity_content,'effect_Fade');
    //objectOpacity_btn
    scrollDisplay(objectOpacity_btn,'effect_Up');
    //objectNews_row
    scrollDisplay(objectNews_row,'effect_leftAndRight');

    //objectAbout
    scrollDisplay(objectAbout,'effect_rotateBig');



    $(window).scroll(function(event){
        scrollDisplay(objectBanner,'effect_DownFade');
        scrollDisplay(objectServerCase,'effect_Rotate180');
        scrollDisplay(objectServerText,'effect_leftGood');
        scrollDisplay(objectPro_title,'effect_right');
        scrollDisplay(objectPro_describe,'effect_li_right');
        scrollDisplay(objectData_form,'effect_Down');
        scrollDisplay(objectData_describe,'effect_Up');
        scrollDisplay(objectOpacity_content,'effect_Fade');
        scrollDisplay(objectOpacity_btn,'effect_Up');
        scrollDisplay(objectNews_row,'effect_leftAndRight');


        scrollDisplay(objectAbout,'effect_rotateBig');
    });

    $(window).unload(function(){
        $(window).scrollTop(0);
    })
});
