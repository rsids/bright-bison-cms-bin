tinyMCEPopup.requireLangPack();

/* Functions for the advlink plugin popup */

function setAttrib(elm, attrib, value) {
	
	var dom = tinyMCEPopup.editor.dom;

	if (typeof(value) == "undefined" || value == null) {
		value = "";
	}

	// Clean up the style
	if (attrib == 'style')
		value = dom.serializeStyle(dom.parseStyle(value), 'a');

	dom.setAttrib(elm, attrib, value);
}

function callbackfn(link, title, target) {
	var inst = tinyMCEPopup.editor;
	var elm, elementArray, i;

	elm = inst.selection.getNode();

	elm = inst.dom.getParent(elm, "A");

	tinyMCEPopup.execCommand("mceBeginUndoLevel");
	// Create new anchor elements
	if (elm == null) {
		inst.getDoc().execCommand("unlink", false, null);
		tinyMCEPopup.execCommand("mceInsertLink", false, "#mce_temp_url#", {skip_undo : 1});

		elementArray = tinymce.grep(inst.dom.select("a"), function(n) {return inst.dom.getAttrib(n, 'href') == '#mce_temp_url#';});
		
		for (i=0; i<elementArray.length; i++){
			setAttrib(elm = elementArray[i], 'href', link);
			setAttrib(elm = elementArray[i], 'title', title);
			setAttrib(elm = elementArray[i], 'target', target);
		}
		var text = inst.selection.getContent();
		if(text == '') {
			text = link;
			if(text.indexOf('mailto:') == 0) {
				text = text.substring(7);
			}
		}
		elm.innerHTML = text;

	} else {
		setAttrib(elm, 'href', link);
		setAttrib(elm, 'title', title);
		setAttrib(elm, 'target', target);
	}
	// Don't move caret if selection was image
	if (elm.childNodes.length != 1 || elm.firstChild.nodeName != 'IMG') {
		inst.focus();
		inst.selection.select(elm);
		inst.selection.collapse(0);
		tinyMCEPopup.storeSelection();
	}

	tinyMCEPopup.execCommand("mceEndUndoLevel");
	tinyMCEPopup.close();
}

function openFileExplorer() {
	tinyMCEPopup.execCommand("mceFileExplorer", true, addFileToLink);
}

function addFileToLink(link) {
	var lc = document.getElementById("Linkchooser");
	lc.setFile(link);
}
function init(){
//	tinyMCEPopup.resizeToInnerSize();
	setTimeout(function() {
		window.resizeTo( 460,660 );
	}, 500);
}


flashvars.callback = "callbackfn";
var prms = {};
var attributes = {};

swfobject.embedSWF("StandAloneTree.swf?v=3.1.1.10&lib=1.4.0", 
					"Linkchooser", 
					"100%", 
					"100%", 
					"10.1.0",
					"/bright/cms/expressInstall.swf",
					flashvars,
					prms,
					attributes);
tinyMCEPopup.onInit.add(init);