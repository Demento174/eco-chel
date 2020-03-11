$( document ).ready(function() {
	search();

	// sortPosts();

	PopUpHide($('.b-popup'));

	$('.add_to_basket').click(function () {

		PopUpShow($('#buy-completed'));

		let id = $(this).attr('data-id');
		let count ;
		if ($(this).parent().siblings('.quantity').find('.number-input__field').length>0){
			count = $(this).parent().siblings('.quantity').find('.number-input__field').val();
		}else{
			count = $(this).siblings('.number-input').find('.number-input__field').val();
		}

		add_to_basket(id,count);

		$(this).css({
			backgroundColor: 'transparent',
			color:'#ffc400',
		});

		setTimeout(function () {
			countInCartUpdate();
		},500);
	});

	$('.page.page-cart .catalog-table__remove-btn').click(function () {

		removeFromBasket($(this));

		setTimeout(function(){
			cartUpdate();
			countInCartUpdate();
		},600);
	});

	$('.page.page-cart .number-input__control').click(function () {

		let key = $(this).parent().parent().parent().attr('data-key');
		let quantity = $(this).siblings('.number-input__field').val();

		quantityCartItems(key,quantity);

		setTimeout(function(){
			cartUpdate();
			countInCartUpdate();
		},600);

	});

	$('#create_order').click(function (e) {
		e.preventDefault();

		if(validate($('#contactForm'))){

			let note={};

			if($('.entity_form').css('display') == 'block'){

				if(validate($('#contactForm'),true)){
					note = {
						'entity_name':$('#entity_name').val(),
						'entity_inn':$('#entity_inn').val(),
						'entity_kpp':$('#entity_kpp').val(),
						'entity_bik':$('#entity_bik').val(),
						'entity_rs':$('#entity_rs').val(),
						'entity_score':$('#entity_score').val(),
					}
				}else{
					return false;
				}
			}

			createOrder($('#inputName').val(),$('#inputEmail1').val(),$('#inputPhone').val(),note);

			emptyCart();

			PopUpShow($('#order-completed'));
		}
	});

	$('#entity').click(function () {
		$('.entity_form').show();
	});

	$('#individual').click(function () {
		$('.entity_form').hide();
	});

	// if($('body').hasClass('page-catalog') && getCookie('mark') !== undefined && getCookie('mark') !== '0'){
	//
	//     var posts = $('.catalog-table__body').find('.catalog-table__row');
	//
	//     $('#select_brand').val(getCookie('mark'));
	//
	//     var target = getCookie('mark');
	//
	//     posts.animate({
	//         'opacity':0
	//     },400);
	//
	//     setTimeout(function () {
	//         posts.css({
	//             'display':'none'
	//         });
	//
	//         $.each(posts,function (index,elem) {
	//
	//             var dataTags = posts.eq(index).attr('data-marks').split(',');
	//
	//             $.each(dataTags,function (dataTagsIndex,dataTagsValue) {
	//
	//                 if(dataTagsValue == target){
	//
	//                     posts.eq(index).css({
	//                         'display':'flex'
	//                     });
	//
	//                     posts.eq(index).animate({
	//                         'opacity':'1'
	//                     });
	//                 }
	//             })
	//         });
	//     },400);
	// }

});

function add_to_basket(id,count=1){
	if(count<1){
		return false;
	}
	let data={
		action:'woocommerce_add_to_cart',
		product_id: id,
		product_sku: '',
		quantity: count,
	};
	$.ajax({
		type: 'post',
		url: myajax.url,
		data: data,
		success: function (response) {

		},
	});
}

function search(){
	$('#search').focus(function () {
		$('.search_response').animate({'opacity':1},400);
	});

	// $('#search').focusout(function () {
	//     $('.search_response').animate({'opacity':0},400);
	// });
	$('.search_response li.close').click(function () {
		$('.search_response').animate({'opacity':0},400);
	});

	$('#search').click(function (e) {
		e.preventDefault();

		if($('#search_input').val() !== ''){
			window.location = $('.link_search').text()+'?search='+$('#search_input').val()+'&brand='+$('select[name="brand"]').val();
		}

		// $('.search_response li').not('.search_response li.close').remove();
		//
		// searchProduct($('#search_input').val(),$('select[name="brand"]').val());
		//
		// $('.search_response li.close').css('opacity',1);
	});
}

function searchProduct(value,mark) {

	let data={
		action:'searchProduct',
		val:value,
		mark:mark
	};

	$.ajax({
		type: 'post',
		url: myajax.url,
		data: data,
		async:false,
		success: function (response) {

			$('.search_response').append(response);
		},
	});
}

function removeFromBasket(element) {

	let key = element.attr('data-key');
	let data={
		action:'removeFromBasket',
		cart_item_key: key,
	};
	$.ajax({
		type: 'post',
		url: myajax.url,
		data: data,
		success: function (response) {

			if (response.error & response.product_url) {
				window.location = response.product_url;
				cosnole.log('Error in Ajax send in Hook woocommerce_cart_item_removed, if you see it< pls send message to Demento174@yandex.ru');
				return false;
			} else {
				if(response==1){
					cartUpdate()

					element.parent().parent().animate({'opacity':0},400);

					setTimeout(function () {
						element.parent().parent().remove();
					},400);

				}
			}
		},
	});
}

function quantityCartItems(key,quantity) {

	let data={
		action:'quantityCartItems',
		cart_item_key: key,
		quantity:quantity
	};
	$.ajax({
		type: 'post',
		url: myajax.url,
		data: data,
		success: function (response) {

		},
	});
}

function cartUpdate() {

	let basketCount = $('.basket_cost');
	let data={
		action:'cartUpdate',
	};
	$.ajax({
		type: 'post',
		url: myajax.url,
		data: data,
		success: function (response) {
			basketCount.text('');
			basketCount.append(' '+JSON.parse(response).price);

		},
	});
}

function countInCartUpdate() {

	let basketCount = $('.basket_count');
	let data={
		action:'cartUpdate',
	};
	$.ajax({
		type: 'post',
		url: myajax.url,
		data: data,
		success: function (response) {

			basketCount.text('');
			basketCount.text(' ('+JSON.parse(response).items+')');

		},
	});
}

function createOrder(name,email,phone,note){
	console.log(note);
	let data={
		action:'create_order',
		first_name:name,
		email:email,
		phone:phone,
		note:note
	};
	// let order = {'order':getCookie('order')};
	// if(typeof order.order !== 'undefined' ){
	//     data.order=order.order;
	// }

	$.ajax({
		type: 'post',
		url: myajax.url,
		data: data,
		async:false,
		success: function (response) {

		},
	});
}

function emptyCart(){
	let data={
		action:'empty_cart',
	};


	$.ajax({
		type: 'post',
		url: myajax.url,
		data: data,
		async:false,
		success: function (response) {


		},
	});
}

function validate(form,entrep = false){
	if(entrep){

		var input = form.find('input').not('.entity_form input');
	}else{
		var input = form.find('input').not('.entity_form input');
	}

	var result=true;

	$.each( input, function(key,value) {

		switch ($(this).attr('type')) {

			case 'text':
				if(!$(this).val()){

					$(this).css({'box-shadow':'0 0 10px 4px #d41313',});

					result=false;
				}else {

					$(this).css({'box-shadow':'none',});
				}
				break;

			case 'email':
				var rv_email = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;

				if(!rv_email.test($(this).val()) || $(this).val() == ''){

					$(this).css({'box-shadow':'0 0 10px 4px #d41313',});

					result=false;
				}else {

					$(this).css({'box-shadow':'none',});
				}
				break;

			case 'tel':
				var rv_phone = /^((8|\+7)[\-]?)?(\(?\d{3}\)?[\-]?)?[\d\-]{7,10}$/;

				if(!rv_phone.test($(this).val()) || $(this).val().length < 11){

					$(this).css({'box-shadow':'0 0 10px 4px #d41313',});

					result=false;
				}else {

					$(this).css({'box-shadow':'none',});
				}
				break;

		}

	});

	return result;
};

function PopUpShow(element){

	element.show();
}

function PopUpHide(element){
	element.hide();
}

function getCookie(name) {
	let matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	));
	return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name, value, days) {

	var expires = "";
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days*24*60*60*1000));
		expires = "; expires=" + date.toUTCString();
	}

	document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function loadmore(){

}
