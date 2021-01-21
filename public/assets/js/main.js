$(document).ready(function () {
    const pageContainer = $('#page-container');
    const btn = $('#menuBtn');

    if ($(this).width() <= 576) {
        pageContainer.addClass('sidebar-hidden');
    }

    $(this).click(function (e) {
        if (!pageContainer.is(e.target) && !$('#menuBtn *').is(e.target) && $(window).width() <= 576) {
            pageContainer.addClass('sidebar-hidden');
        }
    });

    btn.click(function () {
        pageContainer.toggleClass('sidebar-hidden');
    });

    $(window).resize(function () {
        if ($(this).width() <= 576) {
            pageContainer.addClass('sidebar-hidden');
        }
    });

});
