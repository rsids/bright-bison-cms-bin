tinyMCEPopup.requireLangPack();

var FileExplorerDialog = {
	init : function(args) {
		/*var inst = tinyMCEPopup.editor, dom = inst.dom;
	
		// Find out whether an image was selected
		inst.focus();
		inst.selection*/
		flashvars.callback = "insertFile";
		var prms = {};
		var attributes = {};
			
		// Imageloader is added from linkchooser
		if(tinyMCEPopup.getWindowArg('callbackfunction') == undefined) {
			flashvars.filter = "jpg,jpeg,png,gif";
		}
		
		swfobject.embedSWF("StandAloneExplorer.swf?v=4.0.1&lib=1.4.0", 
						"FileExplorer3", 
						"100%", 
						"100%", 
						"10.1.0",
						"/bright/cms/expressInstall.swf",
						flashvars,
						prms,
						attributes);
	},

	insert : function(file, alt, imageUrl, imageTarget, imageAlign, caption, captionUrl) {
		//console.log('insert image '  + file);
		//alert('insert image '  + file);
		if(tinyMCEPopup.getWindowArg('callbackfunction') != undefined) {
			var fn = tinyMCEPopup.getWindowArg('callbackfunction');
			fn(file);
		} else {
			var inst = tinyMCEPopup.editor, dom = inst.dom;
			var html = '###TAG###';
			var img = '<img src="###IMGURL###" border="0" alt="###ALT###" ###ALIGN###/>';
			var url = file;
			
			if(tagwrap != undefined && tagwrap != '') {
				html = tagwrap;
			}
			
			if(urlwrap != undefined && urlwrap != '') {
				url = urlwrap;
				file = file.replace(/(http|https):\/\/.+?\//g, '/');
			}
			
			alt = (alt == null) ? '' : alt.replace('"', '&quot;');
			html = html.split('###TAG###').join(img);
			html = html.split('###IMGURL###').join(url);	
			html = html.split('###URL###').join(file);
			html = html.split('###ALT###').join(alt);

			// Only left and right are valid
			imageAlign = (imageAlign == 'right' || imageAlign == 'left') ? imageAlign : '';
			if(caption != null) {
				// Set float on figure tag instead of img tag
				imageAlign = (imageAlign == '') ? 'left' : imageAlign; 
				html = "<figure float='" + imageAlign + "'>" + html + "<figcaption>" + sanitize(caption) + "</figcaption></figure>";
				imageAlign = '';
			} else {
				if(imageAlign != '') {
					// Apply float
					imageAlign = 'style="float:' + imageAlign + '"';
				}
			}

			html = html.split('###ALIGN###').join(imageAlign);
			
			inst.focus();
			inst.selection.setContent('<br class="_bright" />');

			var patt = '';
			tinymce.each('h1,h2,h3,h4,h5,h6,p'.split(','), function(n) {
				if (patt)
					patt += ',';
				
				patt += n + ' ._bright';
			});
			
			tinymce.each(inst.dom.select(patt), function(n) {
				inst.dom.split(inst.dom.getParent(n, 'h1,h2,h3,h4,h5,h6,p'), n);
			});
			
			dom.setOuterHTML(dom.select('br._bright')[0], html);
			
			//tinyMCEPopup.execCommand('mceInsertRawHTML', false, html);
		
		}

		tinyMCEPopup.close();
	}
};

function sanitize(string) {
	return string.replace('<', '&lt;').replace('>','&gt;');
}

function insertFile(file, alt, imageUrl, imageTarget, imageAlign, caption, captionUrl) {
	// Prevents a weird IE bug which breaks the insert image functionality
	setTimeout(function() {
		FileExplorerDialog.insert(file, alt, imageUrl, imageTarget, imageAlign, caption, captionUrl);
	}, 100);
}

tinyMCEPopup.onInit.add(FileExplorerDialog.init, FileExplorerDialog);