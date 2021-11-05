$(document).ready(function () {
    $('.navTrigger').click(function () {
        $(this).toggleClass('active');
        $(".navList").toggleClass("showList");
        $(".myNav").toggleClass("showNav");
        $(".navList").fadeIn();
    });
})
