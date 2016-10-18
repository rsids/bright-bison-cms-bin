tinyMCEPopup.requireLangPack();

var CodeFormatterDialog = {
	init : function() {

//		var inst = tinyMCEPopup.editor, dom = inst.dom;
		// Get the selected contents as text and place it in the input
		document.getElementById('srccode-pre').innerHTML = tinyMCEPopup.editor.selection.getContent({format : 'text'});
	},

	insert : function() {
		// Insert the contents from the input into the document
		var inst = tinyMCEPopup.editor, dom = inst.dom;
		
		var html = '<pre class="prettyprint">' + document.getElementById('srccode-pre').innerHTML + '</pre>'; 
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
		
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(CodeFormatterDialog.init, CodeFormatterDialog);
