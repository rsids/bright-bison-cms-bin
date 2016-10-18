/**
 * Manages communication between RTE & Bright
 * @author Ids - Fur
 * @version 2.2
 */
var _callback;
var _value;

function openEditor(value, callback) {
	_callback = callback;
	_value = value;
	window.open(cmsdir + 'tinymce/index.php', 'brightcontenteditor', 'width=600,height=500,resizable=1,scrollbars=0,toolbar=0,location=0,directories=0,status=0,menubar=0,copyhistory=0');
	brightcontenteditor.focus();
}

function getCallback() {
	return _callback;
}

function getValue() {
	return _value;
}

function submitForm(content) {
	var fl = document.getElementById("bright_cms");
	fl[_callback].apply(fl, [content]);
}