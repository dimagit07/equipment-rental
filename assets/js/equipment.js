$(document).ready(function($) {
	$('.slider__items').slick({
		arrows: false
	});

	$('.slider__arrow-left').on('click', function() {
		$('.slider__items').slick('slickPrev');
	});

	$('.slider__arrow-right').on('click', function() {
		$('.slider__items').slick('slickNext');
	});

	$('.form__footer input').on('input', function(event) {
		let amount = $(event.target).val();
		let price = $(event.target).data('price');
	    let str = `Total price - ${amount * price} PLN`;
	    $('.form__total').text(str);
	});
});