$(document).ready(function () {
    $('#option').on('click', '#btn-signalement', function () {
        $('#signalement').toggle();
    });

    $(document).on('click', '.panel-btn', function (e) {
        let currentTarget = $(e.currentTarget);

        currentTarget.parent().next().toggle();
    })
})

