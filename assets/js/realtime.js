$(document).ready(function() {
    setInterval(function() {
        $('#realtime').html('<i class="fas fa-clock mr-3"></i>' + moment().format('DD MMMM YYYY') + '<i class="ml-2 mr-2"></i>' + moment().format('hh:mm:ss A'));
    }, 100);
});