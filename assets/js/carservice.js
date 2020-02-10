/**
 * Created by Tankó Péter on
 */
var carservice = {

    checkSearchField: function () {
        var client_name = $.trim($('#client-name').val());
        var client_id_card = $.trim($('#client-id-card').val());
        if (client_name == '' && client_id_card == '') {
            Swal.fire({
                type: 'error',
                title: errorTitle,
                text: errorMsg1,
            });
        } else if (client_name != '' && client_id_card != '') {
            Swal.fire({
                type: 'error',
                title: errorTitle,
                text: errorMsg2,
            });
        } else if (client_id_card != '' && !$.isNumeric(client_id_card)) {
            Swal.fire({
                type: 'error',
                title: errorTitle,
                text: errorMsg3,
            });
        } else {
            var post = {client_name: client_name, client_id_card: client_id_card};
            Swal.showLoading();
            post[csrfName] = csrfHash;
            $.post(
                BASE_URL + 'getclientdata',
                post,
                function (response) {
                    Swal.close();
                    csrfName = response.csrfName;
                    csrfHash = response.csrfHash;
                    if (response.status == true) {
                        $('#result').html(response.html);
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: errorTitle,
                            text: response.error_msg,
                        });
                    }
                }, "json").done(function () {
            });
        }
    },

    getClientData: function () {
        var post = {};
        Swal.showLoading();
        post[csrfName] = csrfHash;
        $.post(
            BASE_URL + "getclients",
            post,
            function (response) {
                Swal.close();
                csrfName = response.csrfName;
                csrfHash = response.csrfHash;
                $('#client-name').val('');
                $('#client-id-card').val('');
                if (response.status == true) {
                    $('#result').html(response.html);
                    $('#client-table').bootstrapTable();
                    carservice.init_table_events();
                }
            }, "json").done(function () {
        });
    },

    init_table_events:function () {
        $('#client-table').on('expand-row.bs.table', function (e, index, row, $detail) {
            var url = false;
            var post = {id: row[0]};
            if (row['_class'] == 'client') {
                url = BASE_URL + 'getcars';
                post = {id: row[0]};
            } else if (row['_class'] == 'cars') {
                url = BASE_URL + 'getservice';
                post = {car_id: row[0], client_id: row['_data'].client_id};
            }
            if (url != false) {
                Swal.showLoading();
                post[csrfName] = csrfHash;
                $.post(
                    url,
                    post,
                    function (response) {
                        Swal.close();
                        csrfName = response.csrfName;
                        csrfHash = response.csrfHash;
                        if (response.status == true) {
                            $detail.html(response.html);
                            if (row['_class'] == 'client') {
                                $('#cars-' + row[0]).bootstrapTable();
                            }
                        }
                    }, "json").done(function () {
                });
            }
        });
    }

};

$('document').ready(function () {
    carservice.init_table_events();
});