define([
    'new_common',
    'ckeditor'
], function() {
    $('#create_crm').on('loaded.bs.modal', function() {
        var $form = $('form', $(this)),
            $inputs = $form.find('input,textarea,select');

        if (CKEDITOR.instances['ckeditor']) {
            CKEDITOR.instances['ckeditor'].destroy();
        }
        CKEDITOR.replace('ckeditor', {
            height: 300,
            filebrowserImageUploadUrl: '/crm/upload'
        });

        $form.find('.btn-primary').off('click').on('click', function() {
            $inputs.filter('[name=content]').val(CKEDITOR.instances['ckeditor'].getData());
            $form.ajaxSubmit({
                success: function(msg) {
                    if (msg.code == 200) {
                        return dialog.success(msg.msg, function() {
                            window.location.reload();
                        });
                    }
                    return dialog.error(msg.msg);
                }
            });
        });
    });

});
