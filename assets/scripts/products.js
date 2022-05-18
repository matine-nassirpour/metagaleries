$(function() {
    $('.form-check-input').on('change',function() {
        $('#searchForm').submit();
    });
});

/*
$(function() {
    let isSmallScreen = window.matchMedia("only screen and (max-width: 1024px)").matches;

    if (isSmallScreen) {
        $(function() {
            $("details").removeAttr('open');
        });
    }
});
 */
