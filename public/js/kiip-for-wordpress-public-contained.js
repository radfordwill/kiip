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

// kiip moment in a container specified by id
// @TODO combine some functions 
jQuery(document).ready(function () {
	// a lot of this came from Home.js etc from a kiip web demo	
	var createContainer, kiip;
	window.homeInit = function (kiipInstance) {
		createContainer(kiipInstance);
		kiipInstance.postMoment(kiipsetPostmoment);
	};

	createContainer = function (kiip) {
		var container = document.createElement('span');
		if (document.getElementById('kiip-moment-container')){
		var list = document.getElementById('kiip-moment-container');
		kiip.setContainer(container);
		list.appendChild(container);
		}
	};

	// notification is a future function
	kiip = new Kiip(kiipsetPublickey, function (unit) {		
		if (!unit) {
			return;
		}
	});
	if (document.getElementById('kiip-moment-container')){
	window.homeInit(kiip);
	return;
	}
});
