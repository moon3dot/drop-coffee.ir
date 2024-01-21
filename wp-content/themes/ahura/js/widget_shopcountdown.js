 function countdown_init(el)
{
    var mainDate = el.attr('mm-date');
    var countDownDate = new Date(parseInt(mainDate)).getTime();
    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = parseInt(countDownDate) - parseInt(now);
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        el.find('#mwtimercountdown').html(`<li>${days}<span>${wsc_data.translate.day}</span></li><li>${hours}<span>${wsc_data.translate.hour}</span></li><li>${minutes}<span>${wsc_data.translate.minute}</span></li><li>${seconds}<span>${wsc_data.translate.seconds}</span></li>`)
        if (distance < 0) {
            clearInterval(x);
            el.find("#mwtimercountdown").html(wsc_data.translate.finished);
        }
    }, 1000);
}