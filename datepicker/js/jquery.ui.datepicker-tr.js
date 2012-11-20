/* Turkish initialisation for the jQuery UI date picker plugin. */
/* Written by Izzet Emre Erkan (kara@karalamalar.net). */
jQuery(function($){
	$.datepicker.regional['tr'] = {
		closeText: 'kapat',
		prevText: '&#x3c;geri',
		nextText: 'ileri&#x3e',
		currentText: 'bug�n',
		monthNames: ['Ocak','�ubat','Mart','Nisan','May�s','Haziran',
		'Temmuz','A�ustos','Eyl�l','Ekim','Kas�m','Aral�k'],
		monthNamesShort: ['Oca','�ub','Mar','Nis','May','Haz',
		'Tem','A�u','Eyl','Eki','Kas','Ara'],
		dayNames: ['Pazar','Pazartesi','Sal�','�ar�amba','Per�embe','Cuma','Cumartesi'],
		dayNamesShort: ['Pz','Pt','Sa','�a','Pe','Cu','Ct'],
		dayNamesMin: ['Pz','Pt','Sa','�a','Pe','Cu','Ct'],
		weekHeader: 'Hf',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['tr']);
});