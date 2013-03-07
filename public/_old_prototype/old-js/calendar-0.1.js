// Calendar Popovers

var calendar = $(mainPanel).find('.calendar'),
    event = calendar.find('li > ul > li > ul > li');

event.popover({
    trigger: 'manual',
    html: true,
    placement: 'left',
    content: function () {
        return $('#eventDetailTemplate').html();
    }
});

event.click(function (e) {
    var name = $(this).attr('data-name'),
        provider = $(this).attr('data-provider'),
        type = $(this).attr('data-type'),
        reason = $(this).attr('data-reason');

    console.log(name + ' , ' + provider + ' , ' + type + ' , ' + reason);

    if ($(this).hasClass('poppedItem')) {

        $(this).popover('hide').removeClass('poppedItem');

    } else {

        $('.poppedItem').popover('hide').removeClass('poppedItem');
        $(this).popover('toggle').addClass('poppedItem');
        $('body').addClass('popped');
    }

    $('.popover').find('dd.name').text(name);
    $('.popover').find('dd.provider').text(provider);
    $('.popover').find('dd.type').text(type);
    $('.popover').find('dd.reason').text(reason);
    $('.popover').find('.popover-inner').prepend('<a class="close" href="#">&times;</a>');

    e.stopPropagation();
});

$('body').click(function (e) {
    if ($(this).hasClass('popped')) {
        $('.poppedItem').popover('hide').removeClass('poppedItem');
        $('body').removeClass('popped');
    }
});

// Show more appointments

var timeSlot = $('.calendar').find('.time');

timeSlot.find('.hiddenPatient').wrapAll('<div class="hidden">').end()
    .find('.hidden').before('<li class="moreItem"><a href="#" class="more">More</a></li>');

var moreLink = timeSlot.find('a.more');

moreLink.click(function (e) {

    e.preventDefault();

    if ($(this).closest('.day').find('.time').hasClass('showMore')) {

        $(this).closest('ul').find('.hidden').slideUp(100, function () {

            $(this).closest('ul').parent('li').removeClass('showMore').removeAttr('style');
        });

        $(this).text('More');

    } else {

        var dayWidth = $(this).closest('.day').outerWidth();

        $(this).closest('.time').addClass('showMore').css('width', dayWidth).end()
            .closest('.time').find('.hidden').slideDown(100);
        $(this).text('Less');

        console.log($(this));
    }
});
