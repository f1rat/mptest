"use strict";

/*===============================================*/
/* APP INIT		 						         */
/*===============================================*/
(function() {
var myApp = new Framework7({

	routes: [
    {
      name: 'main',
      path: '',
      url: './main.html',
      on: {
        pageAfterIn: function (e, page) {
	},
        pageInit: function (e, page) {
		  getSlides();
          getLatestNews();
		  getLatestListings();
		          },
      }
    },
    {
      path: '/blog/',
      url: './blog.html',
      on: {
      pageInit: function (e, page) {
            getFullNews();
      },
      }
    },
        {
      path: '/add-product/',
      url: './add-product.html',
      on: {
      pageInit: function (e, page) {
      getCatListingForDropDown();
      },
      }
    },
    {
      path: '/blank/',
      url: './_blank.html',
      on: {
      pageInit: function (e, page) {

//do whatever

      },
      }
    },
     {
      path: '/machinecatlisting/',
      url: './machine-cat-listing.html',
      on: {
      pageInit: function (e, page) {
            getAllMachines();
      },
      }
    },
    {
      path: '/autocat/',
      url: './auto-categories.html',
      on: {
      pageInit: function (e, page) {
            getCatListing();
      },
      }
    },
      {
      path: '/booking/',
      url: './booking-form.html',
    },
    {
      path: '/faqs/',
      url: './faqs.html'
    },
    {
      path: '/how-it-works/',
      url: './how-it-works.html'
    },
    {
      path: '/junk-cars-search/',
      url: './junk-cars-search.html'
    },
    {
      path: '/login/',
      url: './login.html'
    },
    {
      path: '/product-category/',
      url: './product-category.html'
    },
    {
      path: '/product-single/',
      url: './product-single.html',
      on: {
      pageInit: function (e, page) {
            displayProduct();
      },
      }
    },
    {
      path: '/register/',
      url: './register.html'
    },
    {
      path: '/remember-password/',
      url: './remember-password.html'
    },
    {
      path: '/sitemap/',
      url: './sitemap.html'
    },
    {
      path: '/used-car-parts/',
      url: './used-car-parts.html'
    },
    {
      path: '/users/:userId/',
      url: './user.html',
    },
    {
      path: '/blog-read/',
      url: './blog-read.html',
      on: {
      pageInit: function (e, page) {
            displayFullNews();
      },
      }
    },
    ],
  
  
	root: '#app',
	theme: 'ios',
	swipePanel: 'left',
	touch: {
    tapHold: true,
	},
	view: {
    xhrCache: false,
    pushState: true,
    uniqueHistory: true,
 	},
 	popup: {
    closeByBackdropClick: true,
	},
	lazy: {
    threshold: 50,
    },
    statusbar: {
    overlay: true,
    scrollTopOnClick: true,
    },
		
});

var mySwiper = new Swiper('.swiper-container', {
    speed: 400,
    spaceBetween: 100,
    loop: true,
    autoplay: {
    delay: 5000,
    }
});

/*===============================================*/
/* EXPORT SELECTORS ENGINE		 			     */
/*===============================================*/
var $$ = Dom7;

/*===============================================*/
/* ADD VIEW		 			     				 */
/*===============================================*/
var mainView = myApp.view.create('.view-main', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: true,
    preloadPreviousPage: false,
    iosSwipeBack: false
});


/*=========================================================*/
/* SHOW/HIDE PRELOADER FOR REMOTE AJAX LOADED PAGES		   */
/*=========================================================*/

$$(document).on('ajaxStart', function (e) {
    myApp.showIndicator();
});
$$(document).on('ajaxComplete', function () {
    myApp.hideIndicator();
});



/*==================================================================*/
/* PAGE INIT : HERE, YOU CAN WRITE YOUR CUSTOM JAVASCRIPT/JQUERY    */
/*==================================================================*/

$$(document).on('pageInit', function (e) 
{



/*	
	        if(localStorage.token == "" ){
           //not logged in , redirect to login page
            console.log("screwed it");
  //         myApp.router.navigate('login.html');
           }else{
           // Login 
//           mainView.router.loadPage('login.html');
            console.log("made it");
           }

*/

	
	/* SLIDE SLICK 
	================================*/
	var slickOpts = {
        slidesToShow: 1,
        slidesToScroll: 1,
		arrows: false,
        dots: true,
		centerMode: true,
		centerPadding: '15px',
		adaptiveHeight: true,
    };
    $('#walkthrough-items').slick(slickOpts);
	
	var calendarDefault = myApp.calendar({
		input: '#calendar-default',
	});
	
	
	var pickerDescribe = myApp.picker({
		input: '#picker-time',
		cols: [
			{
				textAlign: 'left',
				values: (function () {
					var arr = [];
					for (var i = 0; i <= 23; i++) { arr.push(i); }
					return arr;
				})(),
			},
			{
				values: ('PM AM').split(' ')
			},
		]
				
	});
}
);


 
//And now we initialize app
myApp.init();

	})(); 