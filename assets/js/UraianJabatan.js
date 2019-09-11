UraianJabatan = function () {
	$(document).ready(function () {
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

		$("select[name='unitkerja']").change(function () {
			var url = window.location.origin
			var current_url = window.location.pathname
			if (current_url.indexOf('tambah') != -1) {
				$("select[name='jabatan']").hide()
				$.ajax({
					type: 'post',
					url: url + '/uraianjabatan/uraianjabatan/daftarjabatan',
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
			} else if ((current_url.indexOf('ubah') != -1) || (current_url.indexOf('cetak') != -1)) {
				if ($("select[name='unitkerja']").val() != '') {
					$("select[name='jabatan']").hide()
					$.ajax({
						type: 'post',
						url: url + '/uraianjabatan/uraianjabatan/daftarubahjabatan',
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
				} else {
					$("#jabatan").html('<option value="">Pilih Unit Kerja Terlebih Dahulu</option>')
				}
			}
		})

		$("select[name='lokasi']").change(function () {
			var url = window.location.origin
			$.ajax({
				type: 'post',
				url: url + '/uraianjabatan/uraianjabatan/daftaralamat',
				data: {
					lokasi: $("select[name='lokasi']").val()
				},
				dataType: 'json',
				cache: false,
				beforeSend: function (e) {
					if (e && e.overrideMimeType) {
						e.overrideMimeType("application/json;charset=UTF-8");
					}
				},
				success: function (response) {
					$("#alamat").val(response.alamat)
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
				}

			})
		})

		$('select[name = "jabatan"]').change(function () {
			// alert('tes')
			var url = window.location.origin;
			var current_url = window.location.pathname;
			if (current_url.indexOf('ubah') != -1) {
				// alert('tes')
				$.ajax({
					type: 'post',
					url: url + '/uraianjabatan/uraianjabatan/pengolahuraianjabatan',
					data: {
						id_jbt: $("#jabatan").val()
					},
					dataType: 'json',
					cache: false,
					beforeSend: function (e) {
						if (e && e.overrideMimeType) {
							e.overrideMimeType("application/json;charset=UTF-8");
						}
					},
					success: function (response) {
						$("#pengolah-uraian-jabatan").text(response.nama_admin);
						// console.log(response);
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
						// console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
					}
				})
			} else {
				return
			}
		})

		$('input[type = "text"],select,textarea').keyup(function (e) {
			if (e.which === 27) {
				$(this).parents(".collapse").collapse('hide')
			}
		})

		$('input[type = "file"]').change(function (e) {
			var filename = $('input[type=file]').val().split('\\').pop()
			$(this).next().text(filename)
		})

		$("input[name*=tugas]").each(function (i, e) {
			$("input[name*=tugas]").eq(i).change(function () {
				if ($("input[name*=tugas]").eq(i).val() != '') {
					$("input[name*=tugas]").eq(i).removeClass('is-invalid')
				}
			})
		})

		$("input[name*=tanggungjawab]").each(function (i) {
			$("input[name*=tanggungjawab]").eq(i).change(function () {
				if ($("input[name*=tanggungjawab]").eq(i).val() != '') {
					$("input[name*=tanggungjawab]").eq(i).removeClass('is-invalid')
				}
			})
		})

		$('#jobdesc-form').submit(function (e) {
			$('#collapseOne select').each(function (i) {
				if ($('#collapseOne select').eq(i).val() == '') {
					$('#collapseOne select').eq(i).addClass('is-invalid')
					$('#collapseOne select').parents(".collapse").collapse('show')
					$('html,body').animate({
						scrollTop: $('#collapseOne').parents(".card").offset().top - 50
					}, 1000)
					e.preventDefault()
				} else {
					$('#collapseOne select').eq(i).removeClass('is-invalid').addClass('is-valid')
				}
			})

			$("#collapseThree input[name*='tugas'],#collapseFour input[name*='tanggungjawab']").each(function (i) {
				if (($("#collapseThree input[name*='tugas']").eq(i).val() != '') && ($("#collapseFour input[name*='tanggungjawab']").eq(i).val() == '')) {
					var tanggungjawab = false
					// var fault = true
					$("#collapseFour input[name*='tanggungjawab']").eq(i).removeClass('is-valid').addClass('is-invalid').parents('.collapse').collapse('show')
					$('html,body').animate({
						scrollTop: $('#collapseFour').parents(".card").offset().top - 50
					}, 1000)
					e.preventDefault()
				} else if (($("#collapseFour input[name*='tanggungjawab']").eq(i).val() != '') && ($("#collapseThree input[name*='tugas']").eq(i).val() == '')) {
					// var fault = true
					var tugas = false
					$("#collapseThree input[name*='tugas']").eq(i).removeClass('is-valid').addClass('is-invalid').parents('.collapse').collapse('show')
					$('html,body').animate({
						scrollTop: $('#collapseThree').parents(".card").offset().top - 50
					}, 1000)
					e.preventDefault()
				}
			})

			// })
			$("#jobdesc-search-form").submit(function (e) {
				$("select").each(function (i) {
					if ($("select").eq(i).val() == '') {
						$("select").eq(i).addClass('is-invalid')
						e.preventDefault()
					}
				})
			})

			$("#jobdesc-search-form select").each(function (i) {
				$("#jobdesc-search-form select").eq(i).change(function () {
					$("#jobdesc-search-form select").eq(i).removeClass('is-invalid')
				})
			})

		})

	})

}
