import 'jquery.typewatch';
import url from './routes';

(function ($) {
    $(document).ready(function () {
        let route = url('search_player');

        let options = {
            callback: function (value) {
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: {
                        search : $("#search").val()
                    }
                }).done(response => {
                    $('#responsePseudo').show().html(response);
                })
            },
            wait: 1000,
            highlight: true,
            allowSubmit: false,
            captureLength: 3
        }

        $("#search").typeWatch(options);
    });
})(jQuery);
