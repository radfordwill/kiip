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
									label: 'Link Url'
								}, {
									type: 'textbox',
									name: 'text',
									label: 'Link Text'
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
								title: 'Insert Button',
								body: [{
									type: 'textbox',
									name: 'link',
									label: 'Button Link'
								}, {
									type: 'textbox',
									name: 'text',
									label: 'Button Label'
								},
								   {
									type: 'colorbox',
									name: 'colorbox',
									label: 'Button Text Color',
									   
                            // text   : '#fff',
                            values : [
                                { text: 'White', value: 'white' },
                                { text: 'Black', value: 'black' },								
                                { text: 'Red', value: 'red' },								
                                { text: 'Blue', value: 'blue' },								
                                { text: 'Green', value: 'green' },								
                                { text: 'Yellow', value: 'yellow' },								
                                { text: 'Orange', value: 'orange' }
                            ]
								},
								   {
									type: 'colorpicker',
									name: 'color',
									label: 'Button Color'
								},],
								onsubmit: function (e) {
									editor.insertContent('[kiip_ad_shortcode type="fullscreen-onclick"] <a onclick="ProcessResponse(); return false;" href="#' + e.data.link + '" style="color:' + e.data.colorbox + ';background-color:' + e.data.color + ';" class="'+kiipsetClick+' kiip-btn">' + e.data.text + '</a>');
								}
							});
						}
					}]
				},

			]
		});
	});
})();
