/**
 * Created by ids on 5/12/14.
 */
(function(bright) {

    var editorStyles = [
        {title : 'Titel', block : 'h1'},
        {title : 'Kop 2', block : 'h2'},
        {title : 'Kop 3', block : 'h3'},
        {title : 'Paragraaf', block : 'p'},
//        {title : 'Afwijkend 1', inline : 'span', classes : 'special-1'},
//        {title : 'Afwijkend 2', inline : 'span', classes : 'special-2'},
//        {title : 'Afwijkend 3', inline : 'span', classes : 'special-3'},
        {title : 'Code', block : 'pre', classes : 'code'}
    ];

    bright.getEditorStyles = function() {
        return editorStyles;
    }

    bright.addEditorStyle = function(definition) {
        editorStyles.push(definition);
    }
})(window.bright = window.bright || {});