var ComponentsEditors = function () {
    var handleSummernote = function () {
        $('#summernote_1').summernote({height: 300, lang: 'fa-IR'});
    }
    return {
        init: function () {
            handleSummernote();
        }
    };
}();
jQuery(document).ready(function() {    
   ComponentsEditors.init(); 
});