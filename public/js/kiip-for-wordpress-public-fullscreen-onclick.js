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
var kiipsetTestmode = php_vars.kiipsetTestmode;
var kiipsetPublickey = php_vars.kiipsetPublickey;
var kiipInstance = new Kiip(kiipsetPublickey, '', '');
var kiipsetPostmoment = php_vars.kiipsetpostMoment;
var kiipsetemail = php_vars.kiipsetemail;
var kiipsetUserid = php_vars.kiipsetUserid;
var kiipsetClick = php_vars.kiipsetClick;
var kiipsetContainer = php_vars.kiipsetContainer;
// all page and or all posts
//var kiipallPosts = php_vars.kiipallPosts;
//var kiipallPages = php_vars.kiipallPages;
//var kiipallPopups = php_vars.kiipallPopups;
//  if kiip is in testmode
if (kiipsetTestmode === 'on') {
    kiipInstance.setTestMode();
    kiipInstance.setEmail(kiipsetemail);
    kiipInstance.setUserId(kiipsetUserid);
    kiipInstance.setContainer(kiipsetContainer);
}
// kiip is in live mode
else {
    kiipInstance.setContainer(kiipsetContainer);
}
// trigger post moment on scrolling to the bottom
// @TODO combine some functions 
// @BUG :flat ads and pop up ads can't exist on same page, triggers same ad type instead of intended.
jQuery(document).ready(function ($) {
    // a lot of this came from Home.js etc from kiip web demo	
    // container "flat" ad on home page only
    // @TODO get page id from php classes and pass it to pageID
    var kiip;

    $(window).scroll(function () {
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
});