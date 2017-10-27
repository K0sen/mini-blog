'use strict';

$(document).ready(function() {

    $('.blog__add_img').on('click', function() {
        if ($(this).prop("checked")) {
            $('.blog__upload_img').css('display', 'block');
        } else {
            $('.blog__upload_img').css('display', 'none');
        }
    });

    $('.show_comments').on('click', function() {
        $(this).siblings('.comments').toggle(600, function() {
            if ($(this).css('display') == 'block')
                $(this).siblings('.show_comments').find('.btn').text('Hide comments');
            else
                $(this).siblings('.show_comments').find('.btn').text('Show comments');
        });
    });

    $('.add_comment').on('click', function() {
        $(this).siblings('.comment_send').show(600, function() {
            $(this).find('textarea').on('change', function() {
                if ($(this).val() == '')
                    $(this).siblings('.btn').attr('disabled', true);
                else
                    $(this).siblings('.btn').attr('disabled', false);
            });
            $(this).siblings('.add_comment').hide();
        });
    });

});