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
var kiipsetClick = php_vars.kiipsetClick;

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
jQuery(document).ready(function ($) {
    var kiip;
        // trigger onclick element
        $((' .') + kiipsetClick).click(function (e) {
            e.preventDefault();
            kiipInstance.postMoment(kiipsetPostmoment);
            kiip = new Kiip(kiipsetPublickey, function (unit) {
                if (!unit) {
                    return;
                }
            });
        });
});
