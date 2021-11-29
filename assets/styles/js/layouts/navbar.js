$(document).ready(function () {
    $('.navTrigger').click(function () {
        $(this).toggleClass('active');
        $(".navList").toggleClass("showList");
        $(".myNav").toggleClass("showNav");
        $(".navList").fadeIn();
    });

    $('#searchPlayer').click(function () {
        $('#formPlayerSearch').toggle();
    })
})
