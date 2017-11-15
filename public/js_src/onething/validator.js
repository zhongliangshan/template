define([
    'onething/dialog',
    'jquery-validator'
], function() {

    $.fn.getPopoverAndTipTarget = function() {
        if ($(this).is('.select2me')) {
            return $(this).prevAll('.select2-container');
        }

        return $(this).parent().is('.input-group') ? $(this).parent() : $(this);
    };

    return {
        // 默认模式
        'default': {
            error: function(message) {
                $(this).closest('.form-group').addClass('has-error');
            },
            success: function() {
                $(this).closest('.form-group').removeClass('has-error');
            }
        },
        // 消息展示
        'message': {
            error: function(message) {
                $(this).closest('.form-group').addClass('has-error');
                $(this).closest('.input-icon').nextAll('.help-block').remove();
                $(this).closest('.input-icon').after('<span class="help-block">' + message + '</span>');
            },
            success: function() {
                $(this).closest('.form-group').removeClass('has-error');
                $(this).closest('.input-icon').nextAll('.help-block').remove();
            }
        },
        // 弹出信息框方式
        'dialog': {
            error: function(message) {
                $(this).data('error', message);
            },
            success: function() {
                $(this).data('error', null);
            },
            beforeSubmit: function() {
                var $error = $(this).find('.validator-error');
                if ($error.length > 0) {
                    dialog.error($error.eq(0).data('error'));
                    return false;
                }
                return true;
            }
        },
        // 提示信息
        'tooltip': {
            error: function(message) {
                $(this).getPopoverAndTipTarget()
                    .tooltip('destroy').data({
                        placement: $(this).data('placement') ? $(this).data('placement') : 'right',
                        title: message,
                        trigger: 'validate'
                    })
                    .tooltip('show');
            },
            success: function() {
                $(this).getPopoverAndTipTarget().tooltip('destroy');
            }
        },
        // 弹出
        'popover': {
            error: function(message) {
                $(this).getPopoverAndTipTarget()
                    .popover('destroy').data({
                        placement: $(this).data('placement') ? $(this).data('placement') : 'right',
                        html: true,
                        content: '<span class="text-danger">' + message + '</span>',
                        trigger: 'validate'
                    })
                    .popover('show');
            },
            success: function() {
                $(this).getPopoverAndTipTarget().popover('destroy');
            }
        }
    };
});

