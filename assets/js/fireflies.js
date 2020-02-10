/**
 * Created by Tankó Péter on
 */
var fireflies = {

    init: function () {
        $("#nameSearch").autocomplete({
            source: function ($request, $response) {
                var post = {settlement: $request.term};
                post[csrfName] = csrfHash;
                $.post(
                    BASE_URL + 'getsettlements',
                    post,
                    function ($responseData) {
                        csrfName = $responseData.csrfName;
                        csrfHash = $responseData.csrfHash;
                        if ($responseData.result.length > 0) {
                            $response($.map($responseData.result, function ($item) {
                                return {
                                    label: $item.name,
                                    value: $item.id,
                                }
                            }));
                        }
                    }, "json").done(function () {
                });
            },
            select: function ($event, $ui) {
                var $value = $ui.item.value;
                var $label = $ui.item.label;
                $("#nameSearch").val($label);
                fireflies.get_hotels( $ui.item.value);
                return false;
            },
            minLength: 3
        });

    },

    get_hotels: function (search_id) {
        $('#hotel-table').html('');
        Swal.showLoading();
        var post = {search_id: search_id};
        post[csrfName] = csrfHash;
        $.post(
            BASE_URL + 'gethotels',
            post,
            function ($responseData) {
                Swal.close();
                csrfName = $responseData.csrfName;
                csrfHash = $responseData.csrfHash;
                if ($responseData.status = true) {
                   $('#hotel-table').html($responseData.response_html);
                }
            }, "json").done(function () {
        });
    },

    orderHotels: function (search_id, order) {
        var post = {search_id: search_id, order: order};
        post[csrfName] = csrfHash;
        $.post(
            BASE_URL + 'orderhotels',
            post,
            function ($responseData) {
                Swal.close();
                csrfName = $responseData.csrfName;
                csrfHash = $responseData.csrfHash;
                if ($responseData.status = true) {
                    $('#hotel-table').html($responseData.response_html);
                }
            }, "json").done(function () {
        });
    }
};

$('document').ready(function () {
    fireflies.init();
});