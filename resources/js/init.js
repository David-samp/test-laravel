
jQuery(function() {
    initSelect2();
    initToastr();

    $('body').tooltip({
        selector: '[data-toggle="tooltip"]'
    });
});


function initToastr() {
    $(toastrInfo).each(function(idx, msg) {
        toastr.info(msg);
    });
    $(toastrSuccess).each(function(idx, msg) {
        toastr.success(msg);
    });
    $(toastrError).each(function(idx, msg) {
        toastr.error(msg);
    });
}
