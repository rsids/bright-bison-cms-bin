tinyMCEPopup.requireLangPack();

/* Functions for the advlink plugin popup */

function setAttrib(elm, attrib, value) {
	var dom = tinyMCEPopup.editor.dom;
	dom.setAttrib(elm, attrib, value);
}


function callbackfn(str) {
	

	tinyMCEPopup.execCommand("mceBeginUndoLevel");

	tinyMCEPopup.execCommand('mceInsertContent', false, str);

	tinyMCEPopup.execCommand("mceEndUndoLevel");
	tinyMCEPopup.close();
}

