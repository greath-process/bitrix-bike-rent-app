$(document).ready(function () {
	$(document).find(".chosen-select").chosen({
		disable_search: true,
		width: "100%",
	});
	$(document).on("click", ".js-status-select", function (e) {
		e.stopPropagation();
	});

	$(".js-status-select .chosen-select").chosen().change(function (e) {
		const status = e.currentTarget.value;
		e.currentTarget.closest('.js-status-select').dataset.status = status;
	})

	var start_work = $('[name="start_worktime"]').val();
	var end_work = $('[name="end_worktime"]').val();
	/********************************Календарь*********************************/
	if ($("div").is("#two-inputs")) {
		$('#two-inputs').dateRangePicker({
			separator: ' to ',
			format: 'DD.MM.YYYY HH:mm',
			startOfWeek: 'monday',
			startDate: moment().add(1, 'hours'),
			language: 'en',
			hoveringTooltip: false,
			monthSelect: true,
			yearSelect: false,
			singleMonth: false,
			time: {
				enabled: true
			},
			swapTime: true,
			getValue: function () {
				if ($('#date-range200').val() && $('#date-range201').val())
					return $('#date-range200').val() + ' to ' + $('#date-range201').val();
				else
					return '';
			},
			setValue: function (s, s1, s2) {
				if ($('[name="param__arend"]:checked').val() == "hours") {
					$('#date-range200').val(s1);
					var date1 = s1.split(' ');
					var date2 = s2.split(' ');
					var time1 = moment(date1[1], 'HH:mm').add(1, 'hours');
					var time2 = moment(date2[1], 'HH:mm').add(1, 'hours');
					var start = moment(start_work, 'HH:mm').add(1, 'hours');
					var end = moment(end_work, 'HH:mm').add(1, 'hours');
					var time_end = date2[1];
					if (time1 < start) // если время меньше чем начало рабочего дня устанавливаем минимальное
						$('#date-range200').val(date1[0] + ' ' + start_work);
					/* время конца должно не превышать:
					 2 часа мин. аренда,
					 2 часа доставка,
					 1 час на возврат */
					if (time2.add("hours", 4) > end)
						time_end = end.subtract(5, 'hours').format("HH") + ':' + time1.minutes();
					$('#date-range201').val(date1[0] + ' ' + time_end.split(':')[0] + ':' + time1.format('mm'));
				} else {
					// правка по ограничению времени 
					var date = new Date(Date.now() + (3600 * 1000 * 1));
					var dub_date = moment.tz(moment().add(1, 'hours'), 'Asia/Dubai').format('L');
					var dd = date.getDate();
					if (dd < 10) dd = '0' + dd;
					dd = dub_date.split('/')[1];
					var mm = date.getMonth() + 1;
					if (mm < 10) mm = '0' + mm;
					mm = dub_date.split('/')[0];
					var yy = date.getFullYear();
					yy = dub_date.split('/')[2];
					var date_now = dd + '.' + mm + '.' + yy;
					var time = moment.tz(moment(s1.split(' ')[1], 'HH:mm'), 'Asia/Dubai');
					// если дата сегодняшняя
					if (s1.split(' ')[0] == date_now) {
						var time_now = moment.tz(moment(), 'Asia/Dubai');
						var new_time = moment.tz(moment().add(1, 'hours'), 'Asia/Dubai').format('HH:mm');
						var choosen_time = s1.split(' ')[1];
						// а время раньше стартового
						if (time < time_now || choosen_time.split(':')[0] < new_time.split(':')[0] || choosen_time.split(':')[1] < new_time.split(':')[1] && choosen_time.split(':')[0] <= new_time.split(':')[0]) {
							// заменяем время на минимальное
							//var new_time = date.getHours() + ':' + date.getMinutes();
							s1 = s1.replace(s1.split(' ')[1], new_time);
							s1 = s1.replace(s1.split(' ')[1], new_time);
							$('.vremya-range').val(new_time);
						}
					}
					// записываем нули
					if ($('.vremya-range:eq(0)').val() == '00:00') s1 = s1.replace(s1.split(' ')[1], '00:00');
					if ($('.vremya-range:eq(1)').val() == '00:00') s2 = s2.replace(s2.split(' ')[1], '00:00');
					$('#date-range200').val(s1);
					$('#date-range201').val(s2);
				}
			},
			// beforeShowDay: function(t) {
			// 	var valid = (moment().isBefore(t));
			// 	var _class = valid ? '' : 'disabled';
			// 	return [valid, _class];
			// }
		}).bind('datepicker-first-date-selected', function (event, obj) {
			/* This event will be triggered when first date is selected */
			if ($('[name="param__arend"]:checked').val() == "hours") {
				// $('#two-inputs').data('dateRangePicker').setStart('2021.08.25','2021.08.25');
				// alert("hours");
			}

			$.ajax({
				type: "POST",
				url: "/ajax/delete_all_products.php",
				success: function (data) { }
			});

		}).bind('datepicker-close', function () {
			/* This event will be triggered before date range picker close animation */
			console.log('before close');
		});
	}

	if ($("div").is("#two-inputs-admin")) {
		$('#date-range300').dateRangePicker({
			format: 'DD.MM.YYYY HH:mm',
			startOfWeek: 'monday',
			language: 'en',
			hoveringTooltip: false,
			monthSelect: true,
			yearSelect: false,
			alwaysOpen: false,

			autoClose: false,
			singleDate: true,
			singleMonth: true,
			time: {
				enabled: true
			}
		})
		$('#date-range301').dateRangePicker({
			format: 'DD.MM.YYYY HH:mm',
			startOfWeek: 'monday',
			language: 'en',
			hoveringTooltip: false,
			monthSelect: true,
			yearSelect: false,
			alwaysOpen: false,

			autoClose: false,
			singleDate: true,
			singleMonth: true,
			time: {
				enabled: true
			}
		})

		// $('#two-inputs-admin').dateRangePicker({
		// 	separator: ' to ',
		// 	format: 'DD.MM.YYYY HH:mm',
		// 	startOfWeek: 'monday',
		// 	// startDate: moment().add('days', 1),
		// 	language: 'en',
		// 	hoveringTooltip: false,
		// 	monthSelect: true,
		// 	yearSelect: false,
		// 	singleMonth: false,
		// 	time: {
		// 		enabled: true
		// 	},
		// 	swapTime: true,
		// 	getValue: function() {
		// 		if ($('#date-range300').val() && $('#date-range301').val() )
		// 			return $('#date-range300').val() + ' to ' + $('#date-range301').val();
		// 		else
		// 			return '';
		// 	},
		// 	setValue: function(s,s1,s2)	{
		// 		$('#date-range300').val(s1);
		// 		$('#date-range301').val(s2);
		// 	},
		// });
	}

	if ($("*").is("#single-inputs-admin")) {
		$('#single-inputs-admin').dateRangePicker({
			format: 'DD.MM.YYYY',
			startOfWeek: 'monday',
			language: 'en',
			hoveringTooltip: false,
			monthSelect: true,
			yearSelect: false,
			alwaysOpen: false,

			autoClose: false,
			singleDate: true,
			singleMonth: true,

			// time: {
			// 	enabled: true
			// }
		})
	}

	/********************************Показ моб меню*********************************/
	$(".mobile-menu").click(function () {
		if ($('body').hasClass('b-page_menu')) {
			$('body').removeClass('b-page_menu');
		} else {
			$('body').addClass('b-page_menu');
		}
	});

	/********************************Показ меню в лк*********************************/
	$(".lk-burger").click(function () {
		if ($(this).hasClass('lk-burger_down')) $(this).removeClass('lk-burger_down');
		else $(this).addClass('lk-burger_down');
	});

	/********************************Подсказка для типа велосипеда*********************************/
	/*$('.question').click(function() {
		if($(this).hasClass('question_active')) $(this).removeClass('question_active');
		else {
			$('.question').removeClass('question_active');
			$(this).addClass('question_active');
		}
		return false;
	});*/

	/********************************Показ пользовательского меню*********************************/
	$('.b-user__ico').click(function () {
		if ($('.b-user').hasClass('b-user_active')) $('.b-user').removeClass('b-user_active');
		else $('.b-user').addClass('b-user_active');
		return false;
	});

	/********************************Слайдер для типа велосипеда*********************************/
	/*$(".fbike").slick({
		arrows: true,
		prevArrow: '<img class="prev" src="">',
		nextArrow: '<div class="fbike-next"><img class="next" src="img/arrow-right.svg"></div>',
		slidesToShow: 3,
		slidesToScroll: 1,
		speed: 300,
		swipeToSlide: true,
		dots: false,
		variableWidth: true,
		infinite: true,
	});*/

	/********************************Слайдер для О нас*********************************/
	$(".about-slide").slick({
		arrows: false,
		slidesToShow: 3,
		slidesToScroll: 1,
		swipeToSlide: true,
		dots: true,
		infinite: true,
		responsive: [{
			breakpoint: 992,
			settings: {
				slidesToShow: 2
			}
		},
		{
			breakpoint: 640,
			settings: {
				slidesToShow: 1
			}
		}]
	});

	$(".ride-page .items-list-wrapper").slick({
		arrows: false,
		slidesToShow: 1,
		slidesToScroll: 1,
		swipeToSlide: true,
		dots: true,
		infinite: true,
		adaptiveHeight: true
	});

	/********************************Скролл для заказов*********************************/
	$(".order-table_check").smoothDivScroll({
		mousewheelScrolling: "horisontal",
		hotSpotScrolling: true,
		manualContinuousScrolling: false,
		touchScrolling: true,
		visibleHotSpotBackgrounds: "always",
		hotSpotsVisibleTime: 2000,
	});

	/********************************Скролл для лк*********************************/
	/*$(".lk-slide").smoothDivScroll({
		mousewheelScrolling: "",
		hotSpotScrolling: true,
		manualContinuousScrolling: true,
		hotSpotScrolling:true,
		visibleHotSpotBackgrounds:"always",
		hotSpotsVisibleTime: 2000,
	});*/

	$('.masc-phone').inputmask({
		"mask": "9(999) 999-99-99"
	});


	/********************************Текущее время*********************************/
	var timeNode = document.getElementById('b-time');

	function getCurrentTimeString2(dots) {
		var timeString = moment.tz(moment(), 'Asia/Dubai').format('HH:mm');
		return timeString;
	}

	timeNode.innerHTML = getCurrentTimeString2();

	setInterval(
		function () {
			timeNode.innerHTML = getCurrentTimeString2();
		},
		30000
	);


	/********************************Показ пароля*********************************/
	$('body').on('click', '.password-control', function () {
		if ($(this).prev().attr('type') == 'password') {
			$(this).addClass('password-control_active');
			$(this).prev().attr('type', 'text');
		} else {
			$(this).removeClass('password-control_active');
			$(this).prev().attr('type', 'password');
		}
		return false;
	});


	/********************************Всплывающие окна*********************************/
	$(document).on('click', 'a[name=modal]', function (e) {
		e.preventDefault();
		if ($(this).attr('id') == "cancel") {
			$('#cancel_order').data('id', $(this).data('id'));
		}
		$('.popup-window.popup-window_active').find('.popup-close').click();
		var id = $(this).attr('href');
		$(id).addClass('popup-window_active');
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
		$('.popup-mask').css({ 'width': maskWidth, 'height': maskHeight });
		//$('.popup-mask').fadeIn(500); 
		$('.popup-mask').fadeTo("normal", 0.8);
		var winH = $(window).height();
		var winW = $(window).width();
		$(id).css('top', winH / 2 - $(id).height() / 2);
		$(id).css('left', winW / 2 - $(id).width() / 2);
		$(id).fadeIn(1000);
	});
	$(document).on('click', '.popup-window .popup-close,.popup-window #popup-close', function (e) {
		e.preventDefault();
		$('.popup-window').removeClass('popup-window_active');
		$('.popup-mask, .popup-window').hide();
	});
	$(document).on('click', '.popup-mask', function () {
		$('.popup-window').removeClass('popup-window_active');
		$(this).hide();
		$('.popup-window').hide();
	});


	/********************************Всплывающие табы авторизация*********************************/
	$('.pop-login__link').click(function (e) {
		e.preventDefault();
		var ids = $(this).attr('href');
		var id = '#popup-lk';
		$('.pop-login__link').removeClass('pop-login_active');
		$(this).addClass('pop-login_active');
		$('.login-tab').fadeOut(500);
		$(ids).fadeIn(500);

		function tabl() {
			var winH = $(window).height();
			var winW = $(window).width();
			$(id).css('top', winH / 2 - $(id).height() / 2);
			$(id).css('left', winW / 2 - $(id).width() / 2);
		}
		setTimeout(tabl, 600);
	});

	$(window).resize(function () {
		var id = '#' + $('.popup-window_active').attr('id');
		var winH = $(window).height();
		var winW = $(window).width();
		$(id).css('top', winH / 2 - $(id).height() / 2);
		$(id).css('left', winW / 2 - $(id).width() / 2);

		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
		$('.popup-mask').css({ 'width': maskWidth, 'height': maskHeight });
	});

	/********************************аккардеон*********************************/
	$(document).on('click', '.lk-item_toggle', function () {
		if ($(this).closest('.accord-item').hasClass('accord-item_active')) {
			$(this).closest('.accord-item').removeClass('accord-item_active');
			$(this).parent().next().fadeOut(500);
		} else {
			$(this).closest('.accord-item').addClass('accord-item_active');
			$(this).parent().next().fadeIn(500);
		}
	});

});


if ($('*').is('.fbike-wrap')) {
	const fbike_scrol = document.querySelector('.fbike-wrap');
	let isDown2 = false;
	let startX2;
	let scrollLeft2;

	fbike_scrol.addEventListener('mousedown', (e) => {
		isDown2 = true;
		fbike_scrol.classList.add('active');
		startX2 = e.pageX - fbike_scrol.offsetLeft;
		scrollLeft2 = fbike_scrol.scrollLeft;
	});
	fbike_scrol.addEventListener('mouseleave', () => {
		isDown2 = false;
		fbike_scrol.classList.remove('active');
	});
	fbike_scrol.addEventListener('mouseup', () => {
		isDown2 = false;
		fbike_scrol.classList.remove('active');
	});
	fbike_scrol.addEventListener('mousemove', (e) => {
		if (!isDown2) return;
		e.preventDefault();
		const x = e.pageX - fbike_scrol.offsetLeft;
		const walk = (x - startX2) * 3; //scroll-fast
		fbike_scrol.scrollLeft = scrollLeft2 - walk;
	});
}

/*if($('*').is('.lk-slide_wrap')) {
	const slider = document.querySelector('.lk-slide_wrap');
	let isDown = false;
	let startX;
	let scrollLeft;

	slider.addEventListener('mousedown', (e) => {
	  isDown = true;
	  slider.classList.add('active');
	  startX = e.pageX - slider.offsetLeft;
	  scrollLeft = slider.scrollLeft;
	});
	slider.addEventListener('mouseleave', () => {
	  isDown = false;
	  slider.classList.remove('active');
	});
	slider.addEventListener('mouseup', () => {
	  isDown = false;
	  slider.classList.remove('active');
	});
	slider.addEventListener('mousemove', (e) => {
	  if(!isDown) return;
	  e.preventDefault();
	  const x = e.pageX - slider.offsetLeft;
	  const walk = (x - startX) * 3; //scroll-fast
	  slider.scrollLeft = scrollLeft - walk;
	});

	var placefix = document.querySelectorAll('.placefix'),
		touchsurface = document.querySelector('.lk-slide_wrap'),

		startY, // get start vertical position
		distX, // get horizontal distance
		distY, // get vertical distance
		positionX,
		newPositionX;

	touchsurface.addEventListener("touchstart", function(e) {



		var touchobj = e.changedTouches[0];

		positionX = -touchsurface.scrollLeft;
		startX = touchobj.pageX;

	});

	touchsurface.addEventListener("touchmove", function(e) {

		var touchobj = e.changedTouches[0];

		distX = touchobj.pageX - startX;

  
			
			for (let elem of placefix) {
				elem.style.left = touchsurface.scrollLeft+'px';
			}
	
	});
}*/

/*CUSTOM*/

$(document).ready(function () {

	/* календарь и ограничения */
	if ($('[name="param__arend"]:checked').val() == "days") { // если по дням
		$('.month2').find('.vremya-range').prop('readOnly', true);
		// $('#two-inputs').daterangepicker({ startDate: moment().add('days', 1)});
	}
	else { // если по часам
		$('.month2').find('.vremya-range').prop('readOnly', false);
		// $('#two-inputs').daterangepicker({ startDate: moment()});
	}

	/* смена времени */
	$(document).on('change', '.month1 .vremya-range', function () {
		if ($('[name="param__arend"]:checked').val() == "days") { // если по дням
			$('.month2').find('.vremya-range').val($(this).val()).trigger('change');
		}
	})

	/* смена типа аренды*/
	$(document).on('change', '[name="param__arend"]', function () {
		var price_code = $(this).data("id");
		$('.b-ftype .price').hide();
		$('.price[id="' + price_code + '"]').show();

		if ($(this).val() == "days") {
			$('.month2').find('.vremya-range').prop('readOnly', true);
			var value = moment($('#date-range200').val(), 'DD.MM.YYYY HH:mm');
			$('#date-range201').val(value.format('DD.MM.YYYY HH:mm'));
		}
		else {
			$('.month2').find('.vremya-range').prop('readOnly', false);
			var value = moment($('#date-range200').val(), 'DD.MM.YYYY HH:mm');
			$('#date-range201').val(value.add('hours', 2).format('DD.MM.YYYY HH:mm'));
		}
	})
	/* кнопка выбрать */
	$(document).on('click', '.rbike-wrap  #btn_choose', function () {
		let id = $(this).data('id');
		var $this = $(this);
		$.ajax({
			type: "POST",
			url: "/ajax/addProduct.php",
			data: { "id": id },
			success: function (data) {
				$this.hide();
				$('.button_take[data-id="' + id + '"]').show();
			}
		});
	})

	/* кнопка отменить выбора */
	$(document).on('click', '.rbike-wrap .button_take', function () {
		let id = $(this).data('id');
		var $this = $(this);
		$.ajax({
			type: "POST",
			url: "/ajax/deleteProduct.php",
			data: { "id": id },
			success: function (data) {
				$this.hide();
				$this.siblings('.button_space').show();
			}
		});
	})

	/* фильтр по брендах */
	$(document).on('change', '[name="param__brand"]', function () {
		var $this = $(this);
		var brand = $this.val();
		var frame = $('[name="param__frame"]').val();
		if ($('[name="param__section"]').length) {
			var section = $('[name="param__section"]').val();
			FilterItems(brand, frame, section);
		} else
			FilterItems(brand, frame);
	})

	/* фильтр по рамах */
	$(document).on('change', '[name="param__frame"]', function () {
		var $this = $(this);
		var frame = $this.val();
		var brand = $('[name="param__brand"]').val();
		console.log(frame)
		if ($('[name="param__section"]').length) {
			var section = $('[name="param__section"]').val();
			FilterItems(brand, frame, section);
		} else
			FilterItems(brand, frame);
	})

	/* фильтр по секциям */
	$(document).on('change', '[name="param__section"]', function () {
		var $this = $(this);
		var section = $this.val();
		var frame = $('[name="param__frame"]').val();
		var brand = $('[name="param__brand"]').val();
		FilterItems(brand, frame, section);
	})
	/***********************   *******************/
	/************ Отправка запросов и форм *******/
	/***********************   *******************/
	// Поиск
	$(document).on('click', '#searchItems', function () {
		var loader = $('.loader');
		var type_arend = $('[name="param__arend"]:checked').val(); // тип аренды
		var sections = [];
		var data_start = $('[name="data_start"]').val();
		var data_end = $('[name="data_end"]').val();
		$('[name="sections[]"]:checked').each(function () {
			sections.push($(this).val());
		});
		if (sections.length == 0)
			var sections = "";
		$.ajax({
			type: "POST",
			url: "/ajax/search_result.php",
			data: { "param__arend": type_arend, "sections": sections, "data_start": data_start, "data_end": data_end },
			beforeSend: function () {
				if ($('.b-result').length) // если уже есть результаты
					$('.b-result').remove(); // удаляем старые результаты
				loader.fadeIn();
			},
			success: function (data) {
				loader.fadeOut();
				$('.loader').after(data);
				$('.b-result').find(".chosen-select").chosen({ // Отображение селектов
					disable_search: true,
					width: "100%",
				});
			}
		});
	})
	// свободные даты
	$(document).on('click', '.rbike-busy a', function (e) {
		e.preventDefault();
		var href = $(this).attr('href');
		var id = $(this).data('id');
		var name = $(this).data('name');
		$.ajax({
			type: "POST",
			url: "/ajax/freeDates.php",
			data: { "id": id, "name": name },
			success: function (data) {
				if ($(href).length)
					$(href).remove()
				$('footer').after(data);
				$('#button_check_dates').click();
			}
		});
	})

	$(document).on('click', '#button_check_dates', function (e) {
		e.preventDefault();
		var id = $(this).data('id');

		var str_arr = $(id).find('[name="disabledDates"]').val();
		var disabledDates = str_arr.split(","); // забронирование даты
		if ($("div").is("#two-inputs_inline")) {
			$(document).find('#two-inputs_inline').dateRangePicker({
				separator: ' to ',
				format: 'DD.MM.YYYY HH:mm',
				startOfWeek: 'monday',
				startDate: moment().add('days', 1),
				language: 'en',
				hoveringTooltip: false,
				monthSelect: true,
				yearSelect: false,
				singleMonth: false,
				inline: true,
				container: '#date-range-container',
				alwaysOpen: true,
				time: {
					enabled: true
				},
				getValue: function () {
					if ($('#date-range100').val() && $('#date-range101').val())
						return $('#date-range100').val() + ' to ' + $('#date-range101').val();
					else
						return '';
				},
				setValue: function (s, s1, s2) {
					$('#date-range100').val(s1);
					$('#date-range101').val(s2);
				},
				locale: {
					format: 'DD.MM.YYYY'
				},
				beforeShowDay: function (date) {
					var currDate = moment(date).format('DD.MM.YYYY');
					return [disabledDates.indexOf(currDate) == -1];
				}

			});
		}

		$(id).addClass('popup-window_active');
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
		$('.popup-mask').css({ 'width': maskWidth, 'height': maskHeight });
		//$('.popup-mask').fadeIn(500);
		$('.popup-mask').fadeTo("normal", 0.8);
		var winH = $(window).height();
		var winW = $(window).width();
		$(id).css('top', winH / 2 - $(id).height() / 2);
		$(id).css('left', winW / 2 - $(id).width() / 2);
		$(id).fadeIn(1000);
	})

	// кнопка "Применить" при выборе свободных дат
	$(document).on('click', '.button_accept', function () {
		var parent = $(this).closest('#popup-freedate');
		var input_from = parent.find('#date-range100').val();
		var input_to = parent.find('#date-range101').val();
		$.ajax({
			type: "POST",
			url: "/ajax/UpdateDates.php",
			data: { "data_start": input_from, "data_end": input_to },
			success: function (data) {
				window.location.href = window.location.href.replace(/[\?#].*|$/, "?back=Y");
			}
		});
	})

	// переход к оформлению
	$(document).on('click', '#checkout', function () {
		var type_arend = $('[name="param__arend"]:checked').val(); // тип аренды
		var type_delivery = $('[name="param__delivery"]').val(); // тип доставки
		var data_start = $('[name="data_start"]').val();
		var data_end = $('[name="data_end"]').val();
		var link = $(this).data('href');
		var sections = [];
		$('[name="sections[]"]:checked').each(function () {
			sections.push($(this).val());
		});
		if (sections.length == 0)
			var sections = "";
		$.ajax({
			type: "POST",
			url: "/ajax/gotoCheckout.php",
			data: { "param__arend": type_arend, "sections": sections, "type_delivery": type_delivery, "data_start": data_start, "data_end": data_end },
			success: function (data) {
				var json = JSON.parse(data);
				if (json == true) // если есть выбранные товары
					document.location.href = link; // переходим на страницу оформления
				else
					$(document).find('#select_bicycle').click();

			}
		});
	})

	/********** ОТМЕНА ЗАКАЗА ***********/
	$(document).on('click', '#cancel_order', function () {
		var id = $(this).data('id');
		$.ajax({
			type: "POST",
			url: "/ajax/CancelOrder.php",
			data: { "id": id },
			success: function (data) {
				console.log(location.pathname);
				if (location.pathname == "/personal/admin/")
					$('#admin_canceled_order').click();
				else
					$('#canceled_order').click();
			}
		});
	})
	// $(document).on('click','#admin_cancel_order',function (){
	// 	var id = $(this).data('id');
	// 	$.ajax({
	// 		type: "POST",
	// 		url: "/ajax/CancelOrder.php",
	// 		data: {"id":id},
	// 		success: function(data){}
	// 	});
	// })
	$(document).on('click', '#popup-reload', function () {
		location.reload();
	})

	/***** БРОНИРОВАНИЕ ****/
	$('#order_form').on('submit', function (event) {
		event.preventDefault();
		var form_data = $(this).serializeArray();

		form_data = form_data.filter(function (obj) {
			return obj.name !== "DATE_RETURN" && obj.name !== "TIME_RETURN";
		});
		var new_date = new Date($('[name="DATE_RETURN"]').val());

		var date_return = new_date.getDate() + "." + new_date.getMonth() + "." + new_date.getFullYear() + " " + $('[name="TIME_RETURN"]').val();

		var count_helmet = $('[name="helmet"]:checked').length;
		var count_lighter = $('[name="lighter"]:checked').length;
		var count_lock = $('[name="lock"]:checked').length;

		var price = $('#TOTAL').text();
		var delivery_price = $('.price_ship').text();
		var phone_num = $('#order_form [name="PHONE"]').val();
		var sms_text = $('#text_sms').val();
		var add_data = {};
		form_data.push(
			{ name: "HELMET", value: count_helmet },
			{ name: "LIGHTER", value: count_lighter },
			{ name: "LOCK", value: count_lock },
			{ name: "DATE_RETURN", value: date_return },
			{ name: "PRICE", value: price },
			{ name: "PRICE_DELIVERY", value: delivery_price }
		);

		var form_data = $.param(form_data);

		var min_price = parseInt($(this).find('[name="min_price"]').val()); // если больше равно минимальной цены
		if (parseInt(price) < min_price && min_price != undefined && min_price != 0) {
			$('#minimum_price').click();
		} else {
			// проверка номера
			$.ajax({
				url: '/ajax/check_phone.php',
				type: 'post',
				data: { numer: phone_num, text: sms_text, step: 'send' },
				success: function (responce) {
					if (responce != '') {
						console.log(responce);
						if (responce.indexOf('false') > -1 || responce == 'false') {
							$('#order_form [name="PHONE"]').css('border', '1px solid red');
						} else {
							$('#popup-sms-send').show();
							$('#order_form [name="PHONE"]').css('border', '1px solid #DDE3EB');
						}
					} else {
						$.ajax({
							type: "POST",
							url: "/ajax/Checkout.php",
							data: form_data,
							success: function (data) {
								var json = JSON.parse(data);
								if (json.STATUS == "success") {
									orderId = json.ORDER_ID;
									document.location.href = "/checkout/confirm.php?ORDER_ID=" + orderId; // переходим на страницу оформления
								}
								if (json.STATUS == "error") {
									$('#error_message').html('');
									$('#error_message').html(json.ERRORS);
									$('#popup-error').click()
								}
							}
						});
					}
				}
			});
		}
	})

	/***** ПРОВЕРКА СМС ****/
	$('#num_check').on('submit', function (event) {
		event.preventDefault();
		if ($("form").is('#order_form')) {
			var form_data = $('#order_form').serializeArray(),
				phone_num = $('#order_form [name="PHONE"]').val(),
				contin = $('#make_order'),
				type = 'order';
		} else {
			var form_data = $('#registration-form').serializeArray(),
				phone_num = $('#registration-form [name="PERSONAL_PHONE"]').val(),
				contin = $('.b-button_registr'),
				type = 'auth';
		}
		var code = $('#num_code').val();
		form_data.push(
			{ name: "numer", value: phone_num },
			{ name: "step", value: 'check' },
			{ name: "code", value: code },
			{ name: "type", value: type },
		);
		$.ajax({
			url: '/ajax/check_phone.php',
			type: 'post',
			data: form_data,
			success: function (responce) {
				if (responce == 'true') {
					// код верный
					$('#popup-sms-send, #error_check_sms').hide();
					if (!$("form").is('#order_form')) {
						$('#registration-form [name="PERSONAL_PHONE"]').addClass('checked');
					}
					contin.click();
				} else {
					$('#error_check_sms').show();
				}
			}
		});
	});

	/**** запоминание полей *****/
	// доп. свойства
	$('[name="lock"],[name="lighter"],[name="helmet"]').on('change', function () {
		var name = $(this).prop('name');
		var id = $(this).data('id');
		if ($(this).is(':checked'))
			var action = 'add';
		else
			var action = 'delete';
		$.ajax({
			type: "POST",
			url: "/ajax/remember_equip.php",
			data: { "id": id, "name": name, "action": action },
			success: function (data) {

			}
		});
	})
	// оплата
	$('[name="PAYMENT_SYSTEM"]').on('change', function () {
		var id = $(this).data('id');
		$.ajax({
			type: "POST",
			url: "/ajax/remember_payment.php",
			data: { "id": id },
			success: function (data) {

			}
		});
	})
	// поля
	$('[name="USER_NAME"],[name="PHONE"],[name="EMAIL"],[name="UF_ADDRESS_DELIVERY"]').on('blur', function () {
		var name = $(this).prop('name');
		var value = $(this).val();
		$.ajax({
			type: "POST",
			url: "/ajax/remember_order_fields.php",
			data: { "name": name, "value": value },
			success: function (data) {
			}
		});
	})

	/**** Личные данные Кнопка редактирования *****/
	$(document).on('click', '#edit_btn', function () {
		$(this).hide();
		$(this).siblings('input').show();
		$(this).closest('form').find('input').not(':input[type=button], :input[type=hidden], :input[type=submit], :input[type=reset]').prop('readonly', false);
		$(this).closest('form').find('.viewblock').hide();
		$(this).closest('form').find('.hideblock').show();
	})


	/*** Обратная связь ***/
	$('.form.cont-form').on('submit', function (e) {
		e.preventDefault();
		var $this = $(this);
		var form_data = $this.serialize();
		if (!$this.find('input.checkbox').is(':checked'))
			$this.find('.label-check').addClass('error');
		else
			$this.find('.label-check').removeClass('error');

		if ($this[0].checkValidity() == true && $this.find('input.checkbox').is(':checked')) {
			$.ajax({
				type: "POST",
				url: "/ajax/feedback_send.php",
				data: form_data,
				success: function (data) {
					var json = JSON.parse(data);
					if (json.STATUS == "success") {
						$this.find("input[type=text], textarea").val(""); // очищаем поля формы
						if ($this.closest('.popup-window_active').length)
							$this.closest('.popup-window_active').find('.popup-close').click();
						$('#popup-success').click();
					}
					if (json.STATUS == "error") {
						$('#error_message').html(json.ERRORS);
						$('#popup-error').click()
					}
				}
			});
		}
	})
	/********************************************* ************************************************/
	/*********************************** Регистрация / Авторизация ***************************************/
	/********************************************* ************************************************/
	$('[name="avtoriz"]').on('click', function () {
		var href = $(this).attr('href');
		$('.pop-login__link[href="' + href + '"]').click();
	});
	//форма авторизации
	$('#auth-form').submit(function () {
		$.ajax({
			type: 'POST',
			url: '/ajax/auth/auth.php',
			data: $(this).serialize(),
			dataType: 'json',
			success: function (result) {
				if (result.status == 'success') {
					window.location = window.location.pathname;
				} else {
					$('.auth-password-text').html(result.message);
				}
			}
		});
		return false;
	});

	//форма регистрации
	$("#registration-form").submit(function () {
		var $this = $(this);
		if (!$this.find('input.checkbox').is(':checked'))
			$this.find('.label-check').addClass('error');
		else
			$this.find('.label-check').removeClass('error');
		if ($this[0].checkValidity() == true && $this.find('input.checkbox').is(':checked')) {

			var phone_num = $('#registration-form [name="PERSONAL_PHONE"]').val();
			var sms_text = $('#text_sms').val();
			var checked = $('#registration-form [name="PERSONAL_PHONE"]').hasClass('checked');
			$.ajax({
				url: '/ajax/check_phone.php',
				type: 'post',
				data: { numer: phone_num, text: sms_text, step: 'send' },
				success: function (responce) {
					console.log(responce);
					if (responce != '' && !checked) {
						if (responce.indexOf('false') > -1 || responce == 'false') {
							$('#registration-form [name="PERSONAL_PHONE"]').css('border', '1px solid red');
						} else {
							$('#popup-sms-send').show();
							$('#registration-form [name="PERSONAL_PHONE"]').css('border', '1px solid #DDE3EB');
						}
					} else {
						$.ajax({
							url: "/ajax/auth/register.php",
							type: 'POST',
							data: $this.serialize(),
							dataType: 'json',
							success: function (result) {
								if (result.status == 'success') {
									$('.register-error-text').html(result.message).css('color', 'green');
									setTimeout(function () {
										window.location = window.location.pathname;
									}, 2000);
								}
								else if (result.status == 'error') {
									$('.register-error-text').html(result.message).css('color', 'red');
								}
							}
						});
					}
				}
			});
		}
		return false;
	});

	//форма восстановления пароля
	$("#reset-form").submit(function () {
		var $this = $(this);
		$.ajax({
			type: "POST",
			url: "/ajax/auth/forgot_pass.php",
			data: $this.serialize(),
			dataType: 'json',
			success: function (result) {
				if (result.status == 'success') {
					$('.reset-password-text').html(result.message).css('color', 'green');
				}
				else {
					$('.reset-password-text').html(result.message).css('color', 'red');
					$this.find('input').not(':input[type=button], :input[type=submit], :input[type=reset]').val('');
				}
			}
		});
		return false;
	});

	/********************************************* ************************************************/
	/*********************************** Кабинет оператора ***************************************/
	/********************************************* ************************************************/
	// Поиск заказов  в админке
	$('#admin_filters').on('submit', function (e) {
		e.preventDefault();
		var form_data = $(this).serialize();
		var loader = $('.loader');
		$.ajax({
			type: "POST",
			url: "/ajax/admin/admin_search_result.php",
			data: form_data,
			beforeSend: function () {
				if ($('.b-ftype').length) // если уже есть результаты
					$('.b-ftype').remove(); // удаляем старые результаты
				loader.fadeIn();
			},
			success: function (data) {
				loader.fadeOut();
				$('.loader').after(data);
				$('.b-ftype').find(".chosen-select").chosen({ // Отображение селектов
					disable_search: true,
					width: "100%",
				});
				$('.b-ftype .js-status-select .chosen-select').chosen().change(function (e) {
					const status = e.currentTarget.value;
					e.currentTarget.closest('.js-status-select').dataset.status = status;
				});
				$('.b-ftype .js-status-select .chosen-select').prop('disabled', true).trigger("chosen:updated");
			}
		});
	})
	// сбросить фильтры
	$('#del_admin_filter').on('click', function (e) {
		e.preventDefault();
		var loader = $('.loader');
		var form = $(this).closest('form');
		form.find('input[type=text]').val('');
		form.find('.parametrs-item').each(function () {
			$(this).find('select').val('all').trigger("chosen:updated");
		});
		$.ajax({
			type: "POST",
			url: "/ajax/admin/admin_delete_filters.php",
			beforeSend: function () {
				if ($('.b-ftype').length) // если уже есть результаты
					$('.b-ftype').remove(); // удаляем старые результаты
				loader.fadeIn();
			},
			success: function (data) {
				loader.fadeOut();
			}
		});
	})
	// включить редактирование заказа
	$(document).on('click', '#admin_order_edit', function (e) {
		e.preventDefault();
		var id = $(this).data('edit');
		$.ajax({
			type: "POST",
			url: "/ajax/admin/admin_edit_order.php",
			data: { "id": id },
			success: function (result) {
				$('.accord-item[data-id="' + id + '"]').html(result);
				$('.accord-item[data-id="' + id + '"]').find(".chosen-select").chosen({ // Отображение селектов
					disable_search: true,
					width: "100%",
				});
				$('.accord-item[data-id="' + id + '"] .js-status-select .chosen-select').chosen().change(function (e) {
					const status = e.currentTarget.value;
					e.currentTarget.closest('.js-status-select').dataset.status = status;
				});
			}
		});
	})
	// удаление товара из заказа
	$(document).on('click', '.js-remove', function (e) {
		e.preventDefault();
		var item = $(this).parent();
		var id = $(this).closest('.accord-item').data('id');
		item.remove();
		recaclTotal(id);
	})
	// добавление товара в заказ
	$(document).on('click', '.js-search-button', function (e) {
		e.preventDefault();
		var parent = $(this).closest('.js-item-container');
		var type = $(this).data('type');
		var start = $(this).data('start');
		var end = $(this).data('end');
		var ids = [];
		parent.find('.lk-line_text').each(function () {
			ids.push($(this).data('id'));
		});
		parent.addClass('js-item-container-edit');
		$.ajax({
			type: "POST",
			url: "/ajax/admin/admin_add_item.php",
			data: { "TYPE_RENT": type, "DATE_START": start, "DATE_END": end, "ids": ids },
			success: function (result) {
				$('.js-search-result').html(result);
			}
		});
	})
	// сохранить добавление товары
	$(document).on('click', '.js-search-close', function (e) {
		e.preventDefault();
		var parent = $(this).closest('.js-item-container');
		var type = $('.accord-item__products-add').data('type');
		var interval = $(this).data('interval');
		var id = $(this).closest('.accord-item').data('id');
		var ids = [];
		$('.js-search-result').find('.rbike-wrap').each(function () {
			if ($(this).find('.button_take').is(":visible"))
				ids.push($(this).data('id'));
		});
		parent.removeClass('js-item-container-edit');
		$.ajax({
			type: "POST",
			url: "/ajax/admin/admin_complete_item.php",
			data: { "ids": ids, "type": type, "interval": interval },
			success: function (result) {
				if (result) {
					$(result).insertBefore('.accord-item__products-add');
					recaclTotal(id);
				}
			}
		});
	})
	// отменить изменения
	$(document).on('click', '#btn_cancel_order_edit', function (e) {
		e.preventDefault();
		var id = $(this).data('id');
		$.ajax({
			type: "POST",
			url: "/ajax/admin/admin_cancel_edit.php",
			data: { "id": id },
			success: function (result) {
				$('.accord-item[data-id="' + id + '"]').html(result);
				$('.accord-item[data-id="' + id + '"]').find(".chosen-select").chosen({ // Отображение селектов
					disable_search: true,
					width: "100%",
				});
				$('.accord-item[data-id="' + id + '"] .js-status-select .chosen-select').chosen().change(function (e) {
					const status = e.currentTarget.value;
					e.currentTarget.closest('.js-status-select').dataset.status = status;
				});
				$('.b-ftype .js-status-select .chosen-select').prop('disabled', true).trigger("chosen:updated");
			}
		});
	})
	// сохранить изменения
	$(document).on('click', '#btn_save_order_edit', function (e) {
		e.preventDefault();
		var id = $(this).data('id');
		var parent = $('.accord-item[data-id="' + id + '"]');
		if (parent.find('[name="PAID"]').val() == "paid")
			var paid = "Y";
		else
			var paid = "";
		var payment = parent.find('[name="PAYMENT_SYSTEM"]').val();
		var delivery = parent.find('[name="DELIVERY"]').val();
		var delivery_address = parent.find('[name="ADDRESS_DELIVERY"]').val();
		var address_return = parent.find('[name="ADDRESS_RETURN"]').val();
		var comment = parent.find('[name="ADMIN_COMMENT"]').val();
		var status = parent.find('[name="STATUS"]').val();
		status = parent.find('option[value="' + status + '"]').data('value');
		recaclTotal(id);
		var price = parseInt(parent.find('.lk-item_price').text()) + " AED";
		var type = parent.find('.accord-item__products-add').data('type'); // тип аренды
		ids = [];
		parent.find('.accord-item__products').find('.lk-line_text').each(function () {
			ids.push($(this).data('id'));
		});
		var order_data = {
			"ORDER_ID": id,
			"ITEMS": ids,
			"PAID": paid,
			"STATUS": status,
			"PRICE": price,
			"TYPE_AREND": type,
			"PAYMENT_SYSTEM": payment,
			"DELIVERY": delivery,
			"ADDRESS_DELIVERY": delivery_address,
			"ADDRESS_RETURN": address_return,
			"ADMIN_COMMENT": comment
		};
		$.ajax({
			type: "POST",
			url: "/ajax/admin/admin_save_edit.php",
			data: order_data,
			dataType: 'json',
			success: function (result) {
				console.log(result.prop);
				if (result.STATUS == "success") {
					$('.accord-item[data-id="' + id + '"]').html(result.HTML);
					$('.accord-item[data-id="' + id + '"]').find(".chosen-select").chosen({ // Отображение селектов
						disable_search: true,
						width: "100%",
					});
					$('.accord-item[data-id="' + id + '"] .js-status-select .chosen-select').chosen().change(function (e) {
						const status = e.currentTarget.value;
						e.currentTarget.closest('.js-status-select').dataset.status = status;
					});
					$('.b-ftype .js-status-select .chosen-select').prop('disabled', true).trigger("chosen:updated");
					parent.prepend("<p class='response-success'>" + result.MESSAGE + "</p>");
					$([document.documentElement, document.body]).animate({
						scrollTop: parent.offset().top
					}, 100);
				}
				else {
					parent.prepend("<p class='response-error'>" + result.ERRORS + "</p>");
					$([document.documentElement, document.body]).animate({
						scrollTop: parent.offset().top
					}, 100);
				}
			}
		});
	})
})


/**** Функции *******/
/* пересчет суммы */
function recaclTotal(id) {
	var parent = $('.accord-item[data-id="' + id + '"]');
	let total = 0;
	parent.find('.lk-line_text').each(function () {
		// let count = parseInt($(this).find('.lk-item_dney').text());
		let price = parseInt($(this).find('.lk-item_itog').text());
		total += price;
	})
	console.log(total)
	parent.find('.lk-item_price').text(total + ' AED');

}
/* фильтрация по свойствам */
function FilterItems(brand = "all", frame = "all", sections = "all") {
	if (brand == "all" && frame == "all" && sections == "all") {
		$('.rbike-wrap').show();
	}
	else {
		$('.rbike-wrap').each(function () {
			let data_frame = $(this).data('frame');
			let data_brand = $(this).data('brand');
			let data_section = $(this).data('section');

			if ((frame == data_frame && sections == data_section && brand == "all") ||
				(brand == data_brand && sections == data_section && frame == "all") ||
				(brand == data_brand && frame == data_frame && sections == "all") ||
				(frame == data_frame && sections == "all" && brand == "all") ||
				(brand == data_brand && sections == "all" && frame == "all") ||
				(sections == data_section && frame == "all" && brand == "all") ||
				(data_brand == brand && data_frame == frame && data_section == sections)
			)
				$(this).show();
			else
				$(this).hide();

		})
	}
	return false;
}
