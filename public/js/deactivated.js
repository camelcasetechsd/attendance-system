if ($('.redirect-deactivated').length) {
    window.setTimeout(function () {
        window.location.href = '/sign/out'
    }, 3000);
}