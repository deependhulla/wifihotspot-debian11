
$(document).ready(function() {
    $('#example').dataTable( {
        "ajax": {
            "url": "result.php",
            "dataSrc": ""
        },
        "columns": [
            { "data": "user_full_name" },
            { "data": "user_mobile" },
            { "data": "user_email" },
            { "data": "user_mac_address" },
            { "data": "user_reg_datetime" },
            { "data": "user_activaton_datetime" }
        ]
    } );
} );

