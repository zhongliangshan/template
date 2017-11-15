define([
    'onething/app',
    'onething/dialog',
    'onething/dom-init'
], function(App) {
    $.fn.modal.Constructor.prototype.enforceFocus = function () { };
    $("body").off("touchmove");
    // 获取当前日期的本月天数
    Date.prototype.days = function() {
        return new Date(this.getFullYear(), (this.getMonth() + 1), 0).getDate();
    };

    window.App = window.App || App;

    App.init();

    // 初始化 DOM
    $(document).domInit();

    // 获取 checkbox 选中数据
    $.fn.checkedValues = function() {
        var values = [];
        $(this).filter(':checked').each(function() {
            if (this.value != '-1' && this.value != 'on') {
                values.push(this.value);
            }
            
        });
        return values;
    };

    // 获取 checkbox 选中数据 组装成键值对
    $.fn.checkedKeyAndValues = function() {
        var values = {};
        $(this).filter(':checked').each(function() {
            if (this.value != '-1' && this.value != 'on') {
                values[this.name] = this.value;
            }
            
        });
        return values;
    };

    // 获取 input数组数据
    $.fn.inputValuesNotNull = function() {
        var values = [];
        $(this).each(function() {
            if (this.value != '' && this.value != '-1' && this.value != 'on') {
               values.push(this.value);
            }
        });
        return values;
    };

    // 获取 input数组数据 组装成键值对
    $.fn.inputKeyAndValuesNotNull = function() {
        var values = {};
        $(this).each(function() {
            if (this.value != '' && this.value != '-1' && this.value != 'on') {
               values[this.name] = this.value;
            }
        });
        return values;
    };

    // AJAX 默认处理
    $.ajaxSetup({
        cache: false,
        dataType: 'json',
        beforeSend: function(xhr) {
            App.blockUI();
        },
        error: function(xhr, status, error) {
            dialog.error('Network Error: ' + (error ? error : status));
        },
        complete: function() {
            App.unblockUI();
        }
    });
});

