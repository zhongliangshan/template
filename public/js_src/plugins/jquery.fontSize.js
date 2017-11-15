// JavaScript Document
/*
 * 版本jquery-1.9.1.js
 * fontSize: 不带参数，字体因过大导致换行时使用，使用方法 $(dom).fontSize();
 *    size: 带参数，可以控制当前字体大小，使用方法 $(dom).size(20);
 * css中关于文字的box，需要定义box的宽度,line-height:npx,height:auto
 */

/*
 * 逐个修改字体大小
 */

$(document).ready(function () {
    $.fn.extend({
        fontSize: function () {
            $(this).each(function () {
                $(this).css({
                    "word-wrap": "break-word",
                    "word-break": "normal"
                }); //设置不换行属性
                var height = $(this).height(); //实际高度
                var size = $(this).css("font-size").replace(/[^0-9]/ig, ""); //文字大小
                var lineHeight = $(this).css("line-height").replace(/[^0-9]/ig, "");
                if (height > lineHeight) {
                    for (var i = size; i > 0; i--) {
                        size = $(this).css("font-size", i);
                        height = $(this).height();
                        if (height <= lineHeight) {
                            size = $(this).css("font-size", i);
                            return false;
                        }
                    }
                }
            });
        },
        size: function (sizeVal) {
            $(this).css("font-size", sizeVal); //参数大小即是字体大小
        }
    });
});
