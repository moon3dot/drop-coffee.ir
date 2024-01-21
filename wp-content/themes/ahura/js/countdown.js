(function ($) {
    $.fn.ahuraCountdown = function (params) {
        var second = 1000,
            minute = second * 60,
            hour = minute * 60,
            day = hour * 24,
            $this, id, time, timer, wrap, target, targets, TargetDate;
        wrap = $(this);
        target = wrap.find('.countdown-tpl');
        id = target.attr('id');
        time = params.time;
        targets = ['second', 'minute', 'hour', 'day'];

        if (time && time !== undefined) {
            $.each(targets, function (key, value) {
                target.append(
                    $('<div/>', {'class': 'time-down ' + value}).append(
                        $('<div/>', {'class': 'num'}),
                        $('<div/>', {'class': 'text', text: params.labels[value]}),
                    ),
                );
            });

            TargetDate = Date.parse(time);
            timer = setInterval(function () {
                let now = Date.parse(new Date()),
                    distance = TargetDate - now;
                target.find('.day .num').text(Math.floor(distance / (day)));
                target.find('.hour .num').text(Math.floor((distance % (day)) / (hour)));
                target.find('.minute .num').text(Math.floor((distance % (hour)) / (minute)));
                target.find('.second .num').text(Math.floor((distance % (minute)) / second));
                if (distance < 0) {
                    clearInterval(timer);
                    wrap.find('.buttons').remove();
                    target.find('.time-down').remove();
                    target.find('.end-content').show();
                }
            }, second);
        }

        setTimeout(function () {
            wrap.find('.counter, .divider-wrap, .content').slideDown();
        }, 300);
    }
})(jQuery);