PemegangPosisi = function () {
	$(document).ready(function () {
		var url = window.location.origin
		let dropdown = $(".dropdown-btn")
		dropdown.each(function (i) {
			dropdown.eq(i).click(function () {
				let dropdownContent = $('.dropdown-container').eq(i)
				dropdownContent.toggleClass("active")
				dropdown.eq(i).toggleClass("active")
			})
		})

		$('.collapse').each(function (i) {
			$('.collapse').eq(i).on('show.bs.collapse', function () {
				$(".card-header button div.triangle-button").eq(i - 1).css({
					'transform': 'rotate(' + 90 + 'deg)'
				})
			})
			$('.collapse').eq(i).on('hide.bs.collapse', function () {
				$(".card-header button div.triangle-button").eq(i - 1).css({
					'transform': 'rotate(' + 0 + 'deg)'
				})
			})
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

		$('input[type = "text"],select').keyup(function (e) {
			if (e.which === 27) {
				$(this).parents(".collapse").collapse('hide')
			}
		})

		$('input[type = "file"]').change(function (e) {
			var filename = $('input[type=file]').val().split('\\').pop()
			$(this).next().text(filename)
		})

		$('#position-form').submit(function (e) {
			$('#collapseOne select').each(function (i) {
				if ($('#collapseOne select').eq(i).val() == '') {
					$('#collapseOne select').eq(i).addClass('is-invalid')
					// $('#collapseOne select').parents(".collapse").collapse()
					$('html,body').animate({
						scrollTop: $('#collapseOne').parents(".card").offset().top - 50
					}, 1000)
					e.preventDefault()
				} else {
					$('#collapseOne select').eq(i).removeClass('is-invalid').addClass('is-valid')
				}
			})
		})

		$("input:radio").each(function (i) {
			$("input:radio").eq(i).change(function () {
				if ($("input:radio").eq(i) != '') {
					if (i % 2 === 0) {
						$('input:radio').eq(i).removeClass('is-invalid').addClass('is-valid')
						$('input:radio').eq(i + 1).removeClass('is-invalid').addClass('is-valid')
					} else {
						$('input:radio').eq(i).removeClass('is-invalid').addClass('is-valid')
						$('input:radio').eq(i - 1).removeClass('is-invalid').addClass('is-valid')
					}
				}
			})
		})

		$("#lkk-form").submit(function (e) {
			$("input:radio").each(function (i) {
				if (!$('input:radio').eq(i).is(":checked")) {
					if (i % 2 === 0) {
						if ((!$('input:radio').eq(i).is(":checked")) && ((!$('input:radio').eq(i + 1).is(":checked")))) {
							$('input:radio').eq(i).addClass('is-invalid')
							$('input:radio').eq(i + 1).addClass('is-invalid')
							$('html,body').animate({
								scrollTop: $('.col-3').parents(".card").offset().top - 50
							}, 1000)
							$('input:radio').eq(i).parents('.collapse').collapse('show')
							e.preventDefault()
						}
					} else {
						if ((!$('input:radio').eq(i).is(":checked")) && ((!$('input:radio').eq(i - 1).is(":checked")))) {
							$('input:radio').eq(i).addClass('is-invalid')
							$('input:radio').eq(i - 1).addClass('is-invalid')
							$('html,body').animate({
								scrollTop: $('.col-3').parents(".card").offset().top - 50
							}, 1000)
							$('input:radio').eq(i).parents('.collapse').collapse('show')
							e.preventDefault()
						}
					}
				} else {
					return
				}
			})
		})

		$('select[name="unitkerja"]').change(function () {
			$("select[name='jabatan']").hide()
			$.ajax({
				type: 'post',
				url: url + '/uraianjabatan/pemegangposisi/daftarjabatan',
				data: {
					id_unitkerja: $("select[name='unitkerja']").val()
				},
				dataType: 'json',
				cache: false,
				beforeSend: function (e) {
					if (e && e.overrideMimeType) {
						e.overrideMimeType("application/json;charset=UTF-8");
					}
				},
				success: function (response) {
					$("#loading").hide()
					$("#jabatan").html(response.list_jabatan).show();

				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
				}

			})
		})

		$('select[name="atasan"]').change(function () {
			var current_url = window.location.pathname
			if (current_url.indexOf('tambah') != -1) {
				if (($('select[name="incomben"]').val() == '') || ($('select[name="incomben"]').val() == $('select[name="atasan"]').val())) {
					$("select[name='incomben']").hide()
					$.ajax({
						type: 'post',
						url: url + '/uraianjabatan/pemegangposisi/saringpegawai',
						data: {
							npp: $("select[name='atasan']").val(),
							pegawai: 'incomben'
						},
						dataType: 'json',
						cache: false,
						beforeSend: function (e) {
							if (e && e.overrideMimeType) {
								e.overrideMimeType("application/json;charset=UTF-8");
							}
						},
						success: function (response) {
							$("#loading").hide()
							$("#incomben").html(response.list_pegawai).show();

						},
						error: function (xhr, ajaxOptions, thrownError) {
							alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
						}

					})
				} else {
					return
				}
			} else if ((current_url.indexOf('ubah') != -1) || (current_url.indexOf('cetak') != -1)) {
				if (current_url.indexOf('lkk') == -1) {
					if (($('select[name="incomben"]').val() == '') || ($('select[name="incomben"]').val() == $('select[name="atasan"]').val())) {
						$("select[name='incomben']").hide()
						$.ajax({
							type: 'post',
							url: url + '/uraianjabatan/pemegangposisi/saringpegawai',
							data: {
								npp: $("select[name='atasan']").val(),
								pegawai: 'ubah_incomben'
							},
							dataType: 'json',
							cache: false,
							beforeSend: function (e) {
								if (e && e.overrideMimeType) {
									e.overrideMimeType("application/json;charset=UTF-8");
								}
							},
							success: function (response) {
								$("#loading").hide()
								$("#incomben").html(response.list_pegawai).show();

							},
							error: function (xhr, ajaxOptions, thrownError) {
								alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
							}

						})
					} else {
						return
					}
				} else if (current_url.indexOf('lkk') != -1) {
					$("select[name='incomben']").hide()
					$.ajax({
						type: 'post',
						url: url + '/uraianjabatan/pemegangposisi/saringpegawai',
						data: {
							npp: $("select[name='atasan']").val(),
							pegawai: 'ubah_incomben_lkk'
						},
						dataType: 'json',
						cache: false,
						beforeSend: function (e) {
							if (e && e.overrideMimeType) {
								e.overrideMimeType("application/json;charset=UTF-8");
							}
						},
						success: function (response) {
							$("#loading").hide()
							$("#incomben").html(response.list_pegawai).show();

						},
						error: function (xhr, ajaxOptions, thrownError) {
							alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
						}

					})
				}
			}
		})

		$('select[name="incomben"]').change(function () {
			if (($('select[name="atasan"]').val() == '') || ($('select[name="incomben"]').val() == $('select[name="atasan"]').val())) {
				$("select[name='atasan']").hide()
				$.ajax({
					type: 'post',
					url: url + '/uraianjabatan/pemegangposisi/saringpegawai',
					data: {
						npp: $("select[name='incomben']").val(),
						pegawai: 'atasan'
					},
					dataType: 'json',
					cache: false,
					beforeSend: function (e) {
						if (e && e.overrideMimeType) {
							e.overrideMimeType("application/json;charset=UTF-8");
						}
					},
					success: function (response) {
						$("#loading").hide()
						$("#atasan").html(response.list_pegawai).show();

					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
					}

				})
			} else {
				return
			}
		})
	})
}
