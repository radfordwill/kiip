/**
 * All of the code for the public-facing JavaScript source
 * resides in this file.
 *
 * Current Jquery loaded with this script.
 *
 **/
// test use strict further
'use strict';
// needs to be a function
// vars

var php_vars, Kiip;
var kiipsetTestMode = php_vars.kiipsetTestMode;
var kiipsetPublickey = php_vars.kiipsetPublickey;
var kiipInstance = new Kiip(kiipsetPublickey, '', '');
var kiipsetPostmoment = php_vars.kiipsetpostMoment;
var kiipsetemail = php_vars.kiipsetemail;
var kiipsetUserid = php_vars.kiipsetUserid;

//  if kiip is in testmode
if (kiipsetTestMode === 'on') {
	kiipInstance.setTestMode();
	kiipInstance.setEmail(kiipsetemail);
	kiipInstance.setUserId(kiipsetUserid);
}
// kiip is in live mode
//else {
//}
// trigger post moment on scrolling to the bottom
// @TODO combine some functions 
jQuery(document).ready(function () {
	// a lot of this came from Home.js etc from kiip web demo	
	var kiip;
	window.homeInit = function (kiipInstance) {
		kiipInstance.postMoment(kiipsetPostmoment);
	};
	kiip = new Kiip(kiipsetPublickey, function (unit) {
		if (!unit) {
			return;
		}
	});
	window.homeInit(kiip);
	return;
});
