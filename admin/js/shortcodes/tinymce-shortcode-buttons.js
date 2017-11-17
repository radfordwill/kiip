/**
 * TinyMCE buttons for custom shortcodes
 image: url + '/../../../assets/images/kiip-logo-mce-32x32.png'
 */
'use strict';
(function () {
	//var kiipsetClick = php_vars.kiipsetClick;
	tinymce.PluginManager.add('kiip_mce_button', function (editor, url) {
		editor.addButton('kiip_mce_button', {
			title: 'Insert Kiip Moment Shortcodes',
			type: 'menubutton',
			icon: 'icon kiip-mce-icon',
			menu: [{
					text: 'Auto Popup Moment',
					value: '[kiip_ad_shortcode type="fullscreen"]',
					onclick: function () {
						editor.insertContent(this.value());
					}
				}, {
					text: 'Container Moment',
					value: '[kiip_ad_shortcode type="contained"]',
					onclick: function () {
						editor.insertContent(this.value());
					}
				}, {
					text: 'On Scroll Moment',
					value: '[kiip_ad_shortcode type="fullscreen-onscroll"]',
					onclick: function () {
						editor.insertContent(this.value());
					}
				}, {
					text: 'On Click Moment',
					onclick: function () {
						editor.insertContent(this.value());
					},
					menu: [{
						text: 'Add to your link',
						onclick: function () {
							editor.windowManager.open({
								title: 'Insert Link',
								body: [{
									type: 'textbox',
									name: 'link',
									label: 'Your Link Url'
								}, {
									type: 'textbox',
									name: 'text',
									label: 'Your Link Text'
								}, ],

								onsubmit: function (e) {
									editor.insertContent('[kiip_ad_shortcode type="fullscreen-onclick"] <a onclick="ProcessResponse(); return false;" href="#' + e.data.link + '" class="'+kiipsetClick+'">' + e.data.text + '</a>');
								}
							});
						}
					}, {
						text: 'Add a button',
						onclick: function () {
							editor.windowManager.open({
								title: 'Insert Link',
								body: [{
									type: 'textbox',
									name: 'link',
									label: 'Your Button Link'
								}, {
									type: 'textbox',
									name: 'text',
									label: 'Your Button Label'
								},
								   {
									type: 'colorpicker',
									name: 'color',
									label: 'Your Button Color'
								},],
								onsubmit: function (e) {
									editor.insertContent('[kiip_ad_shortcode type="fullscreen-onclick"] <a onclick="ProcessResponse(); return false;" href="#' + e.data.link + '" style="background-color:' + e.data.color + '; border-radius: 8px; border: 1px solid #fff;" class="'+kiipsetClick+' button">' + e.data.text + '</a>');
								}
							});
						}
					}]
				},

			]
		});
	});
})();
