/**
 * All of the code for the public-facing JavaScript source
 * resides in this file.
 *
 * Current Jquery loaded with this script.
 *
 **/
// test use strict further
'use strict';
// var
var php_vars, Kiip, phpvarskiipsetTestMode, kiiponScroll;
var phpvarskiipsetTestMode = php_vars.kiipsetTestMode;
var phpvarskiipsetPublickey = php_vars.kiipsetPublickey;
var kiipInstance = new Kiip(phpvarskiipsetPublickey, '', '');
var kiipsetClick = php_vars.kiipsetClick;
var kiipsetContainer = php_vars.kiipsetContainer;
var kiiponScroll = php_vars.kiiponScroll;
// kiip is in testmode
if (phpvarskiipsetTestMode === 'on') {
	kiipInstance.setTestMode();
	kiipInstance.setEmail(php_vars.kiipsetEmail);
	kiipInstance.setUserId(php_vars.kiipsetUserId);
	kiipInstance.setContainer(kiipsetContainer);
}
// kiip is in live mode
else {
	kiipInstance.setContainer(php_vars.kiipsetContainer);
}
// trigger post moment on scrolling to the bottom
jQuery(document).ready(function ($) {
	if (kiiponScroll === '') {
		kiipInstance.postMoment(php_vars.kiipsetpostMoment);
	}
	$(window).scroll(function () {
		if (kiiponScroll === 'on') {
			if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
				$(window).unbind('scroll');
				// alert("near bottom!");
				kiipInstance.postMoment(php_vars.kiipsetpostMoment);
			}
		}
	});
	// trigger onclick element
	$((' .') + kiipsetClick).click(function (e) {
		e.preventDefault();
		kiipInstance.postMoment(php_vars.kiipsetpostMoment);
	});
	//kiipInstance.postMoment(php_vars.kiipsetpostMoment);
});
// JavaScript Document
