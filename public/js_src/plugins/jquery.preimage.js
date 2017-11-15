(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        factory(require('jquery'));
    } else {
        factory(jQuery);
    }
}(function ($) {

    $.fn.preimage = function (options) {

        var settings = $.extend({
            'prefix': 'prev_',
            'types': ['image/gif', 'image/png', 'image/bmp', 'image/jpeg']
        }, options);

        return $(this).change(function () {
            var $preview = $('#' + settings.prefix + (this.id || this.name));

            if (!$preview.is('img')) {
                if ($preview.find('img').length === 0) {
                    $preview = $preview.append('<img src="about:blank" />').find('img');
                } else {
                    $preview = $preview.find('img');
                }
            }

            if (window.FileReader) {

                if(this.files.length==0){
                    $preview.attr('src', 'about:blank').hide();
                    return false;
                }

                for (var i = 0; i < this.files.length; i++) {
                    if ($.inArray(this.files[i].type, settings.types) === -1) {
                        $preview.attr('src', 'about:blank').hide();
                        return false;
                    }
                }

                // 检查size 以KB为单位
                var maxSize = $(this).attr('size');
                if (maxSize) {
                    var size = ((this.files[0].size / 1024)).toFixed(2);
                    if (size > maxSize) {
                        $preview.attr('src', 'about:blank').hide();
                        return false;
                    }
                }

                for (i = 0; i < this.files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function (file) {
                        $preview.attr('src', file.target.result);
                        $preview.show();
                    };
                    reader.readAsDataURL(this.files[i]);
                }
            }
        });
    };

}));
