/**
 * Initializes RTE
 * @author Ids - Fur
 * @version 2.19
 */

var callback;
$(document).ready(function() {
	
	var tplugins = "contextmenu,fileexplorer,linkchooser,macro,style,table,save,advimage,advlink,paste,media,wordcount,codeformatter";
	var tbuttons3 = "tablecontrols,|,charmap,macro,codeformatter";
	if(additionalplugins.length > 0) {
		for(var i = 0; i < additionalplugins.length; i++) {
			tinyMCE.PluginManager.load(additionalplugins[i], '/bright/site/plugins/tinymce/' + additionalplugins[i] + '/editor_plugin_src.js');
		}
		tplugins += ',' + additionalplugins.join(',');
		tbuttons3 += ',|,' + additionalplugins.join(',');
	}
	if(devplugins.length > 0) {
		tplugins += ',' + devplugins.join(',');
		tbuttons3 += ',|,' + devplugins.join(',');

	}
	
	var validElements = {a: ["href", "rel", "rev", "target", "title", "type", "class"], 
					    b: [""],
					    br: ["clear", "class"],
					    em: [""],
					    h1: ["align", "clear", "height", "width", "style"],
					    h2: ["align", "clear", "height", "width", "style"],
					    h3: ["align", "clear", "height", "width", "style"],
					    h4: ["align", "clear", "height", "width", "style"],
					    h5: ["align", "clear", "height", "width", "style"],
					    h6: ["align", "clear", "height", "width", "style"],
					    hr: ["align", "clear", "noshade", "size", "width"],
					    img: ["*"],
					    figcaption :[],
					    figure: ["style", "class"],
					    li: ["align", "clear", "height", "type", "value", "width"],
					    ol: ["align", "clear", "height", "start", "type", "width"],
					    p: ["align", "clear", "height", "width", "class",'style'],
					    pre: ["clear", "width", "wrap", "class"],
					    small: [""],
					    strike: [""],
					    strong: ["style"],
					    sub: [""],
					    sup: [""],
					    tt: [""],
                        samp: [""],
					    iframe: ["*"],
					    u: [""],
					    ul: ["align", "clear", "height", "start", "type", "width"]};
	
	tinyMCE.init({
		// General options
		relative_urls : false,
    	convert_urls : false,
    	theme_advanced_path : false,
		mode : "textareas",
		theme : "advanced",
		plugins : tplugins,
		width: '100%',
		height: '100%',
		auto_focus:'rte',
		entity_encoding : 'named',
		// Theme options
		theme_advanced_buttons1 : "save,cancel,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,forecolor",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,|,bullist,numlist,indent,outdent,|,linkchooser,unlink,fileexplorer,media,cleanup,code,|,sub,sup",
		theme_advanced_buttons3 : tbuttons3,
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "/css/screen.css?v=" + (new Date()).getTime() +",css/style.css?v=" + (new Date()).getTime(),
		
		media_strict : false,
		paste_auto_cleanup_on_paste : true,
		paste_remove_styles: true,
        paste_remove_styles_if_webkit: true,
        paste_strip_class_attributes: true,
        paste_preprocess : pre_paste,
        valid_children : "+body[figure],+body[figcaption],-p[figure],figcaption[a|#text],figure[img|a|figcaption]",
        extended_valid_elements : getValidElements(validElements),

        urlconverter_callback : "brightUrlConvert",
        cleanup_callback : "my_cleanup_callback",
        save_oncancelcallback : cancelEdit,
        init_instance_callback : 'resizeEditorBox',
		/*
	    */
		oninit : loadContent, 
		// Style formats
		style_formats : bright.getEditorStyles()
	});
	if(window.opener) {
		callback = window.opener.getCallback();
	}
	$(window).resize(function() {
		resizeEditorBox(tinyMCE.get('rte'));
	});
	
	// Timeout for IE
	setTimeout(function() {resizeEditorBox(tinyMCE.get('rte'));}, 1000);
});

function getValidElements(el) {
	var els = [];
	for(var prop in el) {
		els.push(prop + '[' + el[prop].join('|') + ']');
	}
	return els.join(',');
}

function cancelEdit() {
	window.opener.focus();
	window.close();
}

function brightUrlConvert(url, node, on_save) {
	// Do some custom URL convertion
	url = url.replace(/&amp;/g, '&');
	// Return new URL
	return url;
}

function pre_paste(pl, o) {
    // Content string containing the HTML from the clipboard
	var content = o.content;
    content = content.replace(/<\/?div[^>]*>/ig, '');
    content = content.replace(/<!--.*?-->/ig, '');
	// Only allow valid unicode characters
	var ranges = ['[\u0020-\u007F]',
					'[\u00A0-\u00FF]',
					'[\u0100-\u017F]',
					'[\u0180-\u024F]',
					'[\u02B0-\u02FF]',
					'[\u0370-\u03FF]',
					'[\u1D00-\u1D7F]',
					'[\u1E00-\u1EFF]',
					'[\u20A0-\u20CF]',
					'[\u2010-\u205E]',
					'[\u2150-\u218F]',
					'[\u2190-\u21FF]'].join('|');
	var regex = new RegExp('(?!(' + ranges + '))', 'g');
	content = content.replace(regex, '\u2327');
	// For some reason, replace with an empty string does not work immediately
	content = content.replace(/\u2327./g, '');
	content = content.replace(/\u2327/g, '');
	// Clean up span tags
	o.content = cleanupSpan(content, true);
}

function my_cleanup_callback(type, value) {
	// see http://wiki.moxiecode.com/index.php/Tin … p_callback
	switch(type) {
		case "get_from_editor":
		case "insert_to_editor":
		case "submit_content":
			value = value.replace(/&amp;/g, "&");
			// Convert double BR to <p>
			value = value.replace(/<br[ ]?[\/]?>\s*<br[ ]?[\/]?>/gi, "</p><p>");
			break;
	}
	
	/**
	 * Clean up empty (useless) <span> tags
	 */
	value = cleanupSpan(value, false);
	return value;
}

function cleanupSpan(value, allspan) {
	if(typeof(value) != 'string') {
		return value;
	}	

	$('#temprepdiv').hide();
	$('#temprepdiv').html(value);
	var matching = true;
	if($('#temprepdiv span').length > 0) {
		while(matching == true) {
			matching = false;
			$('#temprepdiv span').each(function(index) {
				if(allspan || (($(this).attr('class') == '' || $(this).attr('class') == undefined) 
					&& ($(this).attr('style') == '' || $(this).attr('style') == undefined))) {
					
					if($(this).has('span').length == 0) {
						$(this).replaceWith($(this).html());
					} else {
						matching = true;
					}
				}
			});
		}
	}
	
	// Remove empty content tags
	$('#temprepdiv p').each(function (index) {
		if($(this).html().length == 0) {
			$(this).remove();
		}
	});
	// Remove all font tags!
	$('#temprepdiv span').css('font-size', '');
	$('#temprepdiv span').css('font-family', '');
	
	// Remove noscript tags
	$('#temprepdiv noscript').remove();
	value = $('#temprepdiv').html();
	return value;
}

function loadContent() {

	if(window.opener) {
		tinyMCE.get("rte").setContent(window.opener.getValue());
	}
}

function submitForm() {
	var content = tinyMCE.get('rte').getContent();
	window.opener.submitForm(content);
	window.opener.focus();
	window.close();
}

resizeEditorBox = function (editor) {
	
	var h = $(window).height() - $('#rte_tbl > tbody > tr.mceFirst td').first().height() - $('#rte_tbl > tbody > tr.mceLast td').first().height();
	$('.mceIframeContainer').height(h);
	$('.mceIframeContainer').parent().height(h);
}
