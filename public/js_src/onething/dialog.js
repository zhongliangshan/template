define([
    'bootbox'
], function(bootbox) {

    // @see http://bootboxjs.com/#examples
    window.bootbox = window.bootbox || bootbox;

    // 对应 bootbox 的 locales 设置
    var locales = {
        'zh-cn': 'zh_CN',
        'zh-hk': 'zh_TW',
        'en-us': 'en'
    };
    bootbox.setDefaults({
      locale: locales['zh-cn']
    });

    window.dialog = {
        // 打开对话框
        show: function(options) {
            return bootbox.dialog(options);
        },

        // 弹出消息
        alert: function(message , title = 'Message', callback) {
            return bootbox.alert({
                title: '<span class="icon-info">'+ title+'</span>',
                message: message,
                callback: callback
            });
        },

        // 提示信息
        prompt: function(message, callback) {
            return bootbox.prompt({
                title: '<span class="icon-info">' + message + '</span>',
                callback: callback
            });
        },

        // 确认消息
        confirm: function(message, callback) {
            return bootbox.confirm({
                title: '<span class="icon-info">Confirm ?</span>',
                message: message,
                callback: callback
            });
        },

        // 成功提示信息对话框
        success: function(message, callback) {
            return bootbox.alert({
                title: '<span class="icon-success">操作成功 !</span>',
                message: message,
                callback: callback
            });
        },

        // 错误消息对话框
        error: function(message, callback) {
            return bootbox.alert({
                title: '<span class="icon-danger">Error !</span>',
                message: message,
                callback: callback
            });
        },

        // 警告信息对话框
        warning: function(message, callback) {
            return bootbox.alert({
                title: '<span class="icon-warning">Warning !</span>',
                message: message,
                callback: callback
            });
        },

        // 常规消息对话框
        message: function(message, callback) {
            return bootbox.alert({
                title: '<span class="icon-info">Message !</span>',
                message: message,
                callback: callback
            });
        },

        // 常规消自定义title对话框
        messagenew: function(title, message, callback) {
            return bootbox.alert({
                title: '<span class="icon-info">' + title + '</span>',
                message: message,
                callback: callback
            });
        },

        // 全部隐藏
        hideAll: bootbox.hideAll
    };

});
