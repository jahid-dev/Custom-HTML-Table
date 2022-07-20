
(function($) {
function find_page_number(element) {
    element.find('span').remove();
    return parseInt(element.html());
}

// pagination
$(document).on('click', '.ctable_pagination a.page-numbers', function(event) {
    event.preventDefault();
    page = find_page_number($(this).clone());
    var role = jQuery('#ctable_role').val();
    var useroder = jQuery("#username_order").val();
    
    $.ajax({
        url: ctable.ajaxurl,
        type: 'post',
        data: {
            action: 'ctable_pagination_preview',
            page: page,
            useroder : useroder, 
            role : role, 
        },
        success: function(html) {
            $('#ctable_preview').empty();
            $('#ctable_preview').append(html);
        }
    })
});

// role filter
$(document).on('change', '#ctable_role', function(event) {
    var ctable_role = jQuery(this).val();
    var useroder = jQuery("#username_order").val();

    $.ajax({
        url: ctable.ajaxurl,
        type: 'post',
        data: {
            action: 'ctable_role_preview',
            useroder : useroder, 
            role : ctable_role, 
        },
        success: function(html) {
            $('#ctable_preview').empty();
            $('#ctable_preview').append(html);
        }
    })
});

// usernameorder
$(document).on('click', '.userorder', function(event) {
    event.preventDefault();
    var useroder = jQuery("#username_order").val();
    var role = jQuery('#ctable_role').val();
    $.ajax({
        url: ctable.ajaxurl,
        type: 'post',
        data: {
            action: 'ctable_order_preview',
            useroder : useroder, 
            role: role
        },
        success: function(html) {
            $('#ctable_preview').empty();
            $('#ctable_preview').append(html);
        }
    })
});

})(jQuery);