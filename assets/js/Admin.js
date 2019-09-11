Admin = function () {
	$('#form-login').submit(function (e) {
		$('#form-login input').each(function (index, element) {
			if ($('#form-login input').eq(index).val() == '') {
				e.preventDefault()
				$(this).addClass('is-invalid')
			} else {
				$(this).removeClass('is-invalid')
			}
		})
	})

	$('#form-register').submit(function (e) {
		$('#form-register input').each(function (index, element) {
			if ($('#form-register input').eq(index).val() == '') {
				e.preventDefault()
				$(this).addClass('is-invalid')
			} else {
				$(this).removeClass('is-invalid')
			}
		})
	})

	$('#form-forgot').submit(function (e) {
		$('#form-forgot input').each(function (index, element) {
			if ($('#form-forgot input').eq(index).val() == '') {
				e.preventDefault()
				$(this).addClass('is-invalid')
			} else {
				$(this).removeClass('is-invalid')
			}
		})
	})

	$('#change-password-form').submit(function (e) {
		$('#change-password-form input').each(function (index, element) {
			if ($('#change-password-form input').eq(index).val() == '') {
				e.preventDefault()
				$(this).addClass('is-invalid')
			} else {
				$(this).removeClass('is-invalid')
			}
		})
	})

	$(window).resize(function () {
		if ($(window).width() < 700) {
			$("main").removeClass('col-10')
			$("main").addClass('col-12')

			$('.sidebar-button').click(function () {
				$('div.menu-sidebar').toggleClass('active');
			})
		} else if ($(window).width() > 1000) {
			$("main").removeClass('col-12')
			$("main").addClass('col-10')
			$('.sidebar-button').click(function () {
				let sidebar = $('div.menu-sidebar').css('max-width');
				if (sidebar == '0px') {
					$('div.menu-sidebar').css({
						'max-width': ''
					})
					$('div.menu-sidebar p').css({
						'display': ''
					})
					$("main").removeClass('col-12')
					$("main").addClass('col-10')
				} else {
					$('div.menu-sidebar').css({
						'max-width': '0px'
					})
					$('div.menu-sidebar p').css({
						'display': 'none'
					})
					$("main").removeClass('col-10')
					$("main").addClass('col-12')
				}
			})
		}
	})

	if ($(window).width() < 700) {
		$("main").removeClass('col-10')
		$("main").addClass('col-12')

		$('.sidebar-button').click(function () {
			$('div.menu-sidebar').toggleClass('active');
		})
	} else if ($(window).width() > 1000) {
		$('.sidebar-button').click(function () {
			let sidebar = $('div.menu-sidebar').css('max-width');
			if (sidebar == '0px') {
				$('div.menu-sidebar').css({
					'max-width': ''
				})
				$('div.menu-sidebar p').css({
					'display': ''
				})
				$("main").removeClass('col-12')
				$("main").addClass('col-10')
			} else {
				$('div.menu-sidebar').css({
					'max-width': '0px'
				})
				$('div.menu-sidebar p').css({
					'display': 'none'
				})
				$("main").removeClass('col-10')
				$("main").addClass('col-12')
			}
		})
	}

	let dropdown = $(".dropdown-btn")
	dropdown.each(function (i) {
		dropdown.eq(i).click(function () {
			let dropdownContent = $('.dropdown-container').eq(i)
			dropdownContent.toggleClass("active")
			dropdown.eq(i).toggleClass("active")
		})
	})

}
