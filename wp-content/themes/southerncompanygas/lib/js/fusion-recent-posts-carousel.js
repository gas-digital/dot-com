jQuery(window).load(function() {
	jQuery('.swiper-container').each(
		function(){
			var _swiper = jQuery(this),
				_thisSwiper = new Swiper(
				_swiper[0],
				{
					autoplay: {
						delay: 5000
					},
					scrollbar: {
						el: '.swiper-scrollbar',
						hide: false
					},
					slidesPerView: 1,
					slidesPerGroup: 1,
					spaceBetween: 60,
				    breakpoints: {
						480: {
							slidesPerView: 2
						},
					    840: {
						    autoplay: false,
							slidesPerView: _swiper.data('swiper-slides-per-view'),
							freeMode: true,
							freeModeSticky: false,
							mousewheel: true
					    }
				    }
				}
			);
			_thisSwiper.scrollbar.updateSize();
			//console.log(_swiper.data('swiper-slides-per-view'));
		}
	)
});