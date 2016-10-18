/**
 * editor_plugin_src.js
 *
 * Copyright 2012, Fur VOF
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('lipsum');

	tinymce.create('tinymce.plugins.Lipsum', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceLipsum');
			ed.addCommand('mceLipsum', function() {

				ed.selection.setContent('<h1>Lorem ipsum dolor sit amet</h1><p>consectetur adipiscing elit. Nunc euismod, purus at ultricies vulputate, nunc enim gravida mi, sit amet semper nulla risus in lorem. Donec commodo imperdiet mauris ac dapibus. Nunc iaculis dolor quis mi congue at tincidunt lectus sollicitudin. Phasellus laoreet quam a turpis venenatis quis lobortis nisl consequat. Mauris purus magna, sodales ut molestie in, scelerisque et mi. Donec id elit tortor. Phasellus interdum nibh in sem aliquet rhoncus.</p><h2>Donec cursus odio at nunc gravida et gravida justo mollis.</h2><p>Nulla eget orci dui. Duis quis dapibus lorem. Integer hendrerit, lacus vel elementum elementum, sem eros mattis dui, quis euismod lorem nulla et felis. Pellentesque eu arcu libero. Duis iaculis tempus est ac molestie. Nam in eros turpis, sed vulputate massa. Nullam at felis eget nibh dapibus egestas nec ut diam. Proin laoreet turpis venenatis ante posuere in condimentum ante congue.</p><h3>Morbi pretium semper dui nec ultricies.</h3><p>Maecenas gravida elementum dui, at elementum risus eleifend id. Vestibulum aliquet posuere tortor id vehicula. In ipsum nunc, dictum eu euismod sed, viverra in justo. Quisque sit amet elit risus, interdum porttitor mauris. Nulla eleifend placerat volutpat. Pellentesque consectetur, lorem eget volutpat rhoncus, massa diam venenatis orci, quis imperdiet nisl quam sed enim. Ut lobortis posuere risus, non posuere est rutrum sed. Vestibulum ligula ligula, molestie ac malesuada sed, luctus non lacus. Quisque semper massa sed est tincidunt facilisis. Mauris fermentum accumsan massa. Sed a bibendum metus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p><h4>Nulla facilisi.</h4><p>Maecenas mi massa, sodales dapibus congue nec, bibendum sed erat. Donec vulputate, nulla in vehicula pharetra, ante lectus ultrices lacus, quis vulputate leo nisi in mauris. Maecenas sed velit ipsum, non dignissim leo. Vestibulum sed quam nulla, ac interdum arcu. Fusce quis purus ac nisl sagittis facilisis. Sed posuere porttitor orci, quis facilisis elit congue in. Sed viverra auctor sem quis pretium. Mauris vitae felis vitae nunc sagittis scelerisque at facilisis justo. Nulla dignissim ornare arcu at tempus.</p><h5>Praesent sollicitudin scelerisque condimentum.</h5><p>Etiam ac commodo enim. Vivamus lacinia blandit iaculis. Pellentesque vitae eros est. Sed ac lectus lectus. Aenean ipsum orci, mattis quis gravida non, porta facilisis mi. Cras venenatis, mauris porttitor placerat tristique, sapien magna molestie massa, sit amet suscipit nibh purus et tellus. Mauris orci sem, tincidunt ac consectetur in, convallis at sem. Nulla sed mi non sapien varius varius id in nibh. Donec at massa quis leo sodales ullamcorper. Aliquam erat volutpat. Nunc ligula nulla, lobortis id semper et, blandit quis nunc. Vivamus sem leo, aliquet nec consequat vitae, rutrum at felis.</p>');
			});

			// Register lipsum button
			ed.addButton('lipsum', {
				title : 'lipsum.desc',
				cmd : 'mceLipsum',
				image : url + '/img/icons_293.png'
			});

		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Lipsum plugin',
				author : 'Ids Klijnsma',
				authorurl : 'http://www.wewantfur.com',
				infourl : 'http://www.wewantfur.com/contact',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('lipsum', tinymce.plugins.Lipsum);
})();