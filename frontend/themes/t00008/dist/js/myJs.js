/**
 * Created by gohoc on 2017/2/10.
 */
//***************    nav-bomb-add  **************************
// function navBombAdd(){
//     $('.nav-df-phone').toggleClass("visibleNav");
// }
// $(".nav-menu-btn").click(function(){
//     navBombAdd();
// });

//***************    subNav-list-btn  **************************
// $(".nav-item-phone").click(function(){
//     var subNavBtn =$(this).next('.nav-bomb-phone');
//     subNavBtn.toggleClass("visibleNav");
//
//     if(subNavBtn.hasClass("visibleNav")){
//         $(this).children('.nav-bomb-rowIco').attr("src","img/ico_nav_up.png");
//     }
//     else{
//         $(this).children(".nav-bomb-rowIco").attr("src","img/ico_down_more.png");
//     }
//
// });

//***************   home page pc  nav **************************
var navBtn = $(".nav-box .nav-item");
navBtn.click(function(){
    navBtn.removeClass("nav-item-on");
    $(this).addClass("nav-item-on");
});

//***************   home page goUp **************************
$(function(){
    $('.goUp-lt').liMarquee({
        direction:'up',
        scrollamount:40
        // circular:false
    });

    $('.goUp-rt').liMarquee({
        direction:'up',
        scrollamount:40
        // circular:false
    });

});
//***************    芋见甜品  **************************
 function classBomb(){
     $('.phone-class-list').toggleClass("visibleNav");
 }
 $(".class-btn").click(function(){
     classBomb();
 });
//***************    首页产品切换  **************************
 $('.product').css('display','none');
 $('.product').eq(0).css('display','block');
 $('.home-itemC .navItem').css('background','#b2b2b2');
 $('.home-itemC .navItem').eq(0).css('background','#c2aa6a');
 $('#product .navItem').on('mouseover',function(){
	 $('.product').css('display','none');
	 $('.product').eq($(this).parent().attr('rel')).css('display','block');
	 $('.home-itemC .navItem').css('background','#b2b2b2');
	 $('.home-itemC .navItem').eq($(this).parent().attr('rel')).css('background','#c2aa6a');
	 
 })
//***************    甜品展示-详情  **************************
    var proBtn =  $('#pro-detail-btn');
    var contactBtn =  $('#list-contact-btn');
    var tabPro = $('.tab-pro');
    var tabContact = $('.tab-contact');
    proBtn.click(function(){
        proBtn.addClass("btn-choice-on");
        contactBtn.removeClass('btn-choice-on');
        tabPro.css('display','block');
        tabContact.css('display','none');
    });

    contactBtn.click(function(){
        contactBtn.addClass("btn-choice-on");
        proBtn.removeClass('btn-choice-on');
        tabPro.css('display','none');
        tabContact.css('display','block');
    });
  //***************    商品切换url**************************
 $('.shop-slider-content .slide').on('mouseover',function(){
	 var url=$(this).find('img').attr('src');
	 $('#product_url').attr('src',url);
 })
 
 function setNavActive(rel,cate_id)
{
	 navBtn.each(function(){
		if ($(this).attr('rel') == rel)
		{
			$(this).addClass('nav-item-on');
		}
	});
}
//***************    home page(goTop)  **************************
 var goTopItem = $("#go-top-item");
 goTopItem.click(function(){
     $('body,html').animate({scrollTop:0},500);
     var floatTriangle = $(this).parent().find('.triangle-df');
     floatTriangle.addClass('click_display1');
     goTopItem.addClass("goTOp_on");

     setTimeout(function(){
         goTopItem.removeClass("goTOp_on");
         floatTriangle.removeClass('click_display1');
         },600
     )
 });

 
 
 
 