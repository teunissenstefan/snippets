//de copy button doen
new ClipboardJS('#copycodebutton');

//snippets lang
function ChangeSnippetsLang(e){
    if(e.value == "-empty-"){
        window.location='?controller=snippets&action=index';
    }else{
        window.location='?controller=snippets&action=index&lang='+e.value;
    }
}

$(document).ready(function () {
    $(".pagination").rPage();
});