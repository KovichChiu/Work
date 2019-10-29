function soc(input) {
    $.ajax({
        type: "POST",
        async: false,
        url: "http://test.project.test/socket_client.php",
        data: {
            "id": input
        },
        dataType: "text",
        success: function (result) {
            let tgo = "tooltip" + input;
            $('[data-toggle=' + tgo + ']').tooltip({
                title: result
            });
        },
        error: function (e) {
            $.each(e, function (key, value) {
                console.log(key + ": " + value);
            });
        }
    });
}
