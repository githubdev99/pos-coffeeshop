$(document).ready(function () {
	$(".select2").each(function () {
		$(this).select2();
	});

	$(".datepicker").each(function () {
		let paramDatepicker = {};
		if ($(this).data('min-date')) {
			paramDatepicker.minDate = $(this).data('min-date');
		}

		paramDatepicker.dateFormat = "d M Y";

		$(this).flatpickr(paramDatepicker);
	});

	$(".daterangepicker").each(function () {
		$(this).flatpickr({
			dateFormat: "d M Y",
			mode: "range",
		});
	});

	$(".timepicker").each(function () {
		$(this).flatpickr({
			enableTime: !0,
			noCalendar: !0,
			dateFormat: "H:i",
			time_24hr: !0,
			defaultDate: $(this).data('default')
		});
	});

	$(".hide-element").each(function () {
		$(this).hide();
	});
});

function convert_date(date) {
	const d = new Date(date);

	var getDate = d.toJSON().slice(0, 10);
	return getDate;
}

function convert_time(timestamp) {
	const plus0 = num => `0${num.toString()}`.slice(-2);
	const d = new Date(timestamp);

	var getTime = d.toJSON().slice(0, 10) + ' ' + plus0(d.getHours()) + ":" + plus0(d.getMinutes());
	return getTime;
}

function show_alert(params) {
	if (params) {
		if (params.callback) {
			Swal.mixin({
				toast: true,
				position: "top",
				showCloseButton: !0,
				showConfirmButton: false,
				timer: params.timer,
				timerProgressBar: true,
				onOpen: (toast) => {
					toast.addEventListener("mouseenter", Swal.stopTimer)
					toast.addEventListener("mouseleave", Swal.resumeTimer)
				}
			}).fire({
				icon: params.type,
				title: params.message
			}).then(function () {
				window.location = params.callback;
			});
		} else {
			Swal.mixin({
				toast: true,
				position: "top",
				showCloseButton: !0,
				showConfirmButton: false,
				timer: params.timer,
				timerProgressBar: true,
				onOpen: (toast) => {
					toast.addEventListener("mouseenter", Swal.stopTimer)
					toast.addEventListener("mouseleave", Swal.resumeTimer)
				}
			}).fire({
				icon: params.type,
				title: params.message
			});
		}
	} else {
		return Swal.mixin({
			toast: true,
			position: "top",
			showCloseButton: !0,
			showConfirmButton: false,
			timer: 4000,
			timerProgressBar: true,
			onOpen: (toast) => {
				toast.addEventListener("mouseenter", Swal.stopTimer)
				toast.addEventListener("mouseleave", Swal.resumeTimer)
			}
		}).fire({
			icon: "error",
			title: "Ada kesalahan teknis"
		});
	}
}

function trigger_enter(params) {
	if (params.selector && params.target) {
		$(params.selector).keypress(function (e) {
			if (e.which == 13) {
				$(this).blur();
				$(params.target).focus().click();
			}
		});
	} else {
		Swal.mixin({
			toast: true,
			position: "top",
			showCloseButton: !0,
			showConfirmButton: false,
			timer: 4000,
			onOpen: (toast) => {
				toast.addEventListener("mouseenter", Swal.stopTimer);
				toast.addEventListener("mouseleave", Swal.resumeTimer);
			},
		}).fire({
			icon: 'error',
			title: 'Ada kesalahan teknis'
		});
	}
}

function select2_ajax(params) {
	if (params.normal) {
		$(params.selector).select2({
			placeholder: "Pilih salah satu",
		});
		$.ajax({
			url: params.url,
			type: "POST",
			data: {
				params: params.data ? params.data : '',
			},
			dataType: "json",
			success: function (response) {
				var data = response.data;

				if (response.error == false) {
					$(params.selector).append(data.html);
				} else {
					Swal.mixin({
						toast: true,
						position: "top",
						showCloseButton: !0,
						showConfirmButton: false,
						timer: 4000,
						onOpen: (toast) => {
							toast.addEventListener("mouseenter", Swal.stopTimer);
							toast.addEventListener("mouseleave", Swal.resumeTimer);
						},
					}).fire({
						icon: response.type,
						title: response.message,
					});
				}
			},
		});
	} else {
		$(params.selector).each(function () {
			$(this).select2({
				ajax: {
					type: "post",
					url: params.url,
					dataType: "json",
					delay: 250,
					data: function (data) {
						return $.extend({
							term: data.term,
						},
							params.data == undefined ? "" : params.data
						);
					},
					processResults: function (response) {
						return {
							results: response.data,
						};
					},
					cache: true,
				},
			});
		});
	}
}

function show_button(value, element) {
	if (value != "" || value != null) {
		$(element).each(function () {
			$(this).removeAttr("disabled");
		});
	} else {
		$(element).each(function () {
			$(this).attr("disabled");
		});
	}
}

function show_maxlength(name) {
	var name = $('[name="' + name + '"]').attr("name");
	var maxlength = $('[name="' + name + '"]').attr("maxlength");
	var length = $('[name="' + name + '"]').val().length;

	$("#maxlength_" + name).html(length + "/" + maxlength);
}

function number_only(evt) {
	var theEvent = evt || window.event;

	// Handle paste
	if (theEvent.type === "paste") {
		key = event.clipboardData.getData("text/plain");
	} else {
		// Handle key press
		var key = theEvent.keyCode || theEvent.which;
		key = String.fromCharCode(key);
	}
	var regex = /[0-9]|\./;
	if (!regex.test(key)) {
		theEvent.returnValue = false;
		if (theEvent.preventDefault) theEvent.preventDefault();
	}
}

function running_rupiah(name, value) {
	$('[name="' + name + '"]').val(format_rupiah(value));
}

function running_rupiah_array(find, name, value) {
	$(find)
		.find('[name="' + name + '"]')
		.val(format_rupiah(value));
}

function format_rupiah(angka) {
	var number_string = angka.replace(/[^,\d]/g, "").toString(),
		split = number_string.split(","),
		sisa = split[0].length % 3,
		rupiah = split[0].substr(0, sisa),
		ribuan = split[0].substr(sisa).match(/\d{3}/gi);

	if (ribuan) {
		separator = sisa ? "." : "";
		rupiah += separator + ribuan.join(".");
	}

	rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
	return rupiah;
}

function rupiah(number) {
	var reverse = number.toString().split("").reverse().join(""),
		ribuan = reverse.match(/\d{1,3}/g);
	ribuan = ribuan.join(".").split("").reverse().join("");
	return "Rp" + ribuan;
}