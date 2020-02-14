$(document).ready(function(){
    $('span.editable').click(function(){
        $(this).hide();
        $(this).prev('input').show().focus();
    });
    $('input.editable').blur(function(){
        $(this).hide();
        $val = $(this).val();
        $(this).next('span').html($val).show().focus();
    });
    $('form[name=tree] a.submit_button').click(function(){
        $('form[name=tree]').submit();
    });
    $('form[name=tree] a.reset_button').click(function(){
        $('form[name=tree]')[0].reset();
        $('span.editable').each(function(){
            thisid = $(this).attr('id');
            $(this).html($(this).prev('input').val());
        });
    });
});