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

datepicker.regional['sr-SR'] = {
	closeText: 'Zatvori',
	prevText: '&#x3C;',
	nextText: '&#x3E;',
	currentText: 'Danas',
	monthNames: ['Januar','Februar','Mart','April','Maj','Jun',
	'Jul','Avgust','Septembar','Oktobar','Novembar','Decembar'],
	monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
	'Jul','Avg','Sep','Okt','Nov','Dec'],
	dayNames: ['Nedelja','Ponedeljak','Utorak','Sreda','Četvrtak','Petak','Subota'],
	dayNamesShort: ['Ned','Pon','Uto','Sre','Čet','Pet','Sub'],
	dayNamesMin: ['Ne','Po','Ut','Sr','Če','Pe','Su'],
	weekHeader: 'Sed',
	dateFormat: 'dd.mm.yy',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: ''};
datepicker.setDefaults(datepicker.regional['sr-SR']);

return datepicker.regional['sr-SR'];

}));
