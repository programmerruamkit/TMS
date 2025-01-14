// Call the dataTables jQuery plugin
$(document).ready(function () {
    $('#dataTable').DataTable();
});

function send_ajax_data(element, page, data) {
    var xhttp = new XMLHttpRequest();
    if (data != '') {
        pages = page + "?" + data;
        xhttp.open("GET", pages, false);
        xhttp.send();
        document.getElementById(element).innerHTML = xhttp.responseText;
    }
}
