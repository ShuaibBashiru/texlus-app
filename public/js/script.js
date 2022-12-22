
$(document).ready(function(){
$("#callAlertSuccess").toast('hide', {
    autohide: true,
});
$("#callAlertPrimary").toast('hide', {
    autohide: true,
});
$("#callAlertInfo").toast('hide', {
    autohide: true,
});
$("#callAlertDanger").toast('hide', {
    autohide: true,
});
$("#callAlertWarning").toast('hide', {
    autohide: true,
}); 
$("#callAlertDefault").toast('hide', {
    autohide: true,
});

$('#toggleHideBtn').on('click', function () {
    $('#togglePanel, #togglePanel_1, #togglePanel_2').toggleClass('col-1 col-2');
    $('#contentPanel').toggleClass('col-md-10 col-md-11');
    $('.toggleHide').toggleClass('d-none');
    $('#toggleHideBtn').toggleClass('bi-arrow-right-short bi-list');
});

});
