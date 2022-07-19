
(function($) {
function find_page_number(element) {
    element.find('span').remove();
    return parseInt(element.html());
}
$(document).on('click', '.ctable_pagination a.page-numbers', function(event) {
    event.preventDefault();
    page = find_page_number($(this).clone());
    var role = jQuery('#ctable_role').val();
    
    $.ajax({
        url: ctable.ajaxurl,
        type: 'post',
        data: {
            action: 'ctable_pagination_preview',
            page: page,
            role : role, 
        },
        success: function(html) {
            $('#ctable_preview').empty();
            $('#ctable_preview').append(html);
            // console.log(html);
        }
    })
});

$(document).on('change', '#ctable_role', function(event) {
    var ctable_role = jQuery(this).val();
    
    $.ajax({
        url: ctable.ajaxurl,
        type: 'post',
        data: {
            action: 'ctable_role_preview',
            role : ctable_role, 
        },
        success: function(html) {
            $('#ctable_preview').empty();
            $('#ctable_preview').append(html);
            // console.log(html);
        }
    })
});

})(jQuery);