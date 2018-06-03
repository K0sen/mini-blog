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
        var post_id = $(this).parents('.post').children('.post__id').val();
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var id = $(this).siblings('.comment__id').val();
        if (!id)
            id = 0;

        $.ajax({
            url: '/comment/form',
            type: 'post',
            data: {
                parent_id : id,
                post_id : post_id,
                '_csrf-frontend' : csrfToken
            },
            success: function (data) {
                $('.comment_send').remove();
                if (id != 0) {
                    $('.comment input[value='+id+']').siblings('.add_comment').before(data);
                }
                else {
                    $('.post input[value='+post_id+']').siblings('.add_comment').before(data);
                }

                $('.comment_send_close').on('click', function() {
                    console.log(123);
                    $('.comment_send').remove();
                });
            }
        });
    });

});