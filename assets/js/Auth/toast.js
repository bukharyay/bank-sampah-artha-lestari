;(function ($) {
	showSuccessToast = function (message) {
		'use strict'
		resetToastPosition()
		$.toast({
			heading: 'Success',
			text: message,
			showHideTransition: 'slide',
			position:'top-center',
			icon: 'success',
			loaderBg: '#46c35f', // Warna loader hijau
			bgColor: '#28a745', // Warna latar belakang hijau tua
			textColor: '#ffffff', // Warna teks putih
			hideAfter: 5000,
		})
	}

	showInfoToast = function (message) {
		'use strict'
		resetToastPosition()
		$.toast({
			heading: 'Info',
			text: message,
			showHideTransition: 'slide',
			position:'top-center',
			icon: 'info',
			loaderBg: '#57c7d4', // Warna loader cyan
			bgColor: '#17a2b8', // Warna latar belakang biru tua
			textColor: '#ffffff', // Warna teks putih
			hideAfter: 5000,
		})
	}

	showWarningToast = function (message) {
		'use strict'
		resetToastPosition()
		$.toast({
			heading: 'Peringatan',
			text: message,
			showHideTransition: 'slide',
			position:'top-center',
			icon: 'warning',
			loaderBg: '#f6e84e', // Warna loader kuning
			bgColor: '#ffc107', // Warna latar belakang kuning tua
			textColor: '#ffffff', // Warna teks putih
			hideAfter: 5000,
		})
	}

	showDangerToast = function (message) {
		'use strict'
		resetToastPosition()
		$.toast({
			heading: 'Gagal',
			text: message,
			showHideTransition: 'slide',
			position:'top-center',
			icon: 'error',
			loaderBg: '#f2a654', // Warna loader oranye
			bgColor: '#dc3545', // Warna latar belakang merah tua
			textColor: '#ffffff', // Warna teks putih
			hideAfter: 5000,
		})
	}

	resetToastPosition = function () {
		$('.jq-toast-wrap').removeClass(
			'bottom-left bottom-right top-left top-right mid-center'
		)
		$('.jq-toast-wrap').css({
			top: '',
			left: '',
			bottom: '',
			right: ''
		})
	}
})(jQuery)
