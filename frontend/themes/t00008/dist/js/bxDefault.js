/**
 * Created by htshen on 2017/3/3.
 */
var url = $('body').attr('name');
new_element=document.createElement("script");
new_element.setAttribute("type","text/javascript");
new_element.setAttribute("src",url);// 在这里引入了a.js
document.body.appendChild(new_element);

$(document).ready(function(){

    $('.banner-slider').bxSlider({
        slideWidth: 1920,
        hideControlOnEnd: true,
        slideMargin: 0,
        autoDelay:3000,
        controls:true,
        nextSelector: "ho_nextBtn",
        prevSelector: "ho_prevBtn",
        infiniteLoop: true,
        auto: true
    });

    var shopBox = $('.shop-slider-box');
    var shopSlider = $('.shop-slider-content')
    shopSlider.bxSlider({
        slideWidth:113,
        minSlides: 4,
        maxSlides: 4,
        slideMargin: 10,
        autoDelay:3000,
        infiniteLoop: false,
        moveSlides: 1,
        pager:false,
        auto: false,
        nextText: '',
        prevText: '',
        nextSelector: '.swiper-df-right',
        prevSelector: '.swiper-df-left'

    });

    //

    var viewPort = shopBox.find('.bx-viewport');
    var shopListWidth = viewPort.width();
    var val = (Number(shopListWidth)-30) * 0.25;
    viewPort.height("auto");
    shopSlider.bxSlider({
        slideWidth:val,
        minSlides: 4,
        maxSlides: 4,
        slideMargin: 10,
        autoDelay:3000,
        infiniteLoop: false,
        moveSlides: 1,
        pager:false,
        auto: false,
        nextText: '',
        prevText: '',
        nextSelector: '.swiper-df-right',
        prevSelector: '.swiper-df-left',
        //
        onSliderResize:function(){
            viewPort = $('.bx-viewport');
            shopListWidth = viewPort.width();
            val = (Number(shopListWidth)-30) * 0.25;
            viewPort.height("auto");
            shopSlider.find('.slide').width(val);
            shopBox.find('.bx-wrapper').css('max-width','none');
        }
    });
    //***************   home page itemG **************************
    var navItemG = $(".ho-wrap1-list li");
    var sliderG  = $('.ho-slider1').bxSlider({
        // slideWidth: 1920,
        hideControlOnEnd: true,
        slideMargin: 0,
        controls:false,
        infiniteLoop: false,
        pager:false,
        auto: false,
        onSlideAfter: function(){
            var  currentG = sliderG.getCurrentSlide();

            if( currentG == tagG)
            {}
            else{
                sliderG.goToSlide(tagG);
            }
        }
    });
    navItemG.eq(0).addClass("itemG_li_on");
    navItemG.mouseover(function(){
        tagG = ($(this).index());
        setTimeout(function () {
            sliderG.goToSlide(tagG)
        },200);
        navItemG.removeClass("itemG_li_on");
        $(this).addClass("itemG_li_on");
    });



    //***************   home page itemH **************************
    var navItemH = $(".slider-H-nav li");

    var sliderH = $('.slider-H').bxSlider({
        //slideWidth: 1200,
        hideControlOnEnd: true,
        slideMargin: 0,
        controls:false,
        infiniteLoop: false,
        pager:false,
        auto: false,
        onSlideAfter: function(){
            // console.log("2、tagH:" +tagH);
            var  current = sliderH.getCurrentSlide();
            // console.log("3、current:" +current);
            if( current == tagH)
            {}
            else{
                sliderH.goToSlide(tagH);
            }
            // console.log("4、tagH:" +tagH);
        }
    });

    navItemH.eq(0).addClass("itemH_li_on");
    navItemH.mouseover(function(){
        tagH = ($(this).index());
        setTimeout(function () {
            sliderH.goToSlide(tagH)
        },200);
        navItemH.removeClass("itemH_li_on");
        $(this).addClass("itemH_li_on");
    });


});


