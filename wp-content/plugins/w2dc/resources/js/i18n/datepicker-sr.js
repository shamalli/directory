/* Serbian i18n for the jQuery UI date picker plugin. */
/* Written by Dejan Dimić. */
"use strict";(function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define([ "../datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.datepicker );
	}
}(function( datepicker ) {

datepicker.regional['sr'] = {
	closeText: 'Затвори',
	prevText: '&#x3C;',
	nextText: '&#x3E;',
	currentText: 'Данас',
	monthNames: ['Јануар','Фебруар','Март','Април','Мај','Јун',
	'Јул','Август','Септембар','Октобар','Новембар','Децембар'],
	monthNamesShort: ['Јан','Феб','Мар','Апр','Мај','Јун',
	'Јул','Авг','Сеп','Окт','Нов','Дец'],
	dayNames: ['Недеља','Понедељак','Уторак','Среда','Четвртак','Петак','Субота'],
	dayNamesShort: ['Нед','Пон','Уто','Сре','Чет','Пет','Суб'],
	dayNamesMin: ['Не','По','Ут','Ср','Че','Пе','Су'],
	weekHeader: 'Сед',
	dateFormat: 'dd.mm.yy',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: ''};
datepicker.setDefaults(datepicker.regional['sr']);

return datepicker.regional['sr'];

}));
