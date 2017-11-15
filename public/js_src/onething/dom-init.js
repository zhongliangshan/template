define([
    'onething/validator',
    'onething/dialog',
    'bootstrap-datepicker',
    'datetimepicker',
    'jquery-form'
], function(vSetting) {

    // AJAX 默认成功回调
    var ajaxSuccssCallback = function(data, redirect) {
        if (data.code !== 200) {
            return dialog.error(data.message);
        }

        var callback = function() {
            if (typeof redirect === 'string') {
                if (redirect !== 'off') {
                    setTimeout(function() {
                        document.location.href = redirect;
                    }, 1000);
                }
            } else {
                setTimeout(function() {
                    document.location.reload();
                }, 1000);
            }
        };

        if (data.message) {
            return dialog.success(data.message, callback);
        }

        return callback(data);
    };

    // AJAX 表单默认处理
    var ajaxSubmitForm = function(e) {
        e.preventDefault();

        var $form = $(this);

        $form.ajaxSubmit({
            success: function(data) {
                ajaxSuccssCallback(data, $form.data('redirect'));
            }
        });
    };

    ONETHING.initEvents = ONETHING.initEvents || [
        // 处理日期控件
        function($dom) {
            $dom.find('.date-picker').datetimepicker({
                format: "yyyy-mm-dd",
                kind: "dtkTime",
                autoclose: true,
                todayBtn: true,
                minView: 'month',
                pickerPosition: "bottom-left"
            });
        },

        // 处理日期控件 不会自动加载 ,精确到时分
        function($dom) {
            $dom.find('.datetime-picker').datetimepicker({
                format: "yyyy-mm-dd hh:ii",
                kind: "dtkTime",
                autoclose: true,
                todayBtn: true,
                pickerPosition: "bottom-left"
            });
        },
        // 处理日期控件 不会自动加载,只选择到月份
        function($dom) {
            $dom.find('.month-picker').datetimepicker({
                language: 'zh-cn',
                format: 'yyyy-mm',
                autoclose: true,
                todayBtn: true,
                startView: 'year',
                minView: 'year',
                maxView: 'decade'
            });
        },
        // 处理日期控件 不会自动加载,只选择从月份开始
        function($dom) {
            $dom.find('.day-picker').datetimepicker({
                kind: "dtkTime",
                format: 'dd',
                autoclose: true,
                todayBtn: true,
                startView: 'month',
                minView: 'month',
            });
        },

        // 处理日期控件 不会自动加载,只选择从月份开始
        function($dom) {
            $dom.find('.time-picker').datetimepicker({
                format: 'hh:ii',
                autoclose: true,
                todayBtn: true,
                startView: 'day',
            });
        },
        function($dom) {
            $dom.find('.select2').each(function(i, obj) {
                if (!$(obj).data("select2")) {
                    $(obj).select2();
                }
            });
        },
        // 绑定checkbox的全选和反选事件 
        function($dom) {
            $dom.find('.first_checkable').off('click').on('click', function() {
                var checked = $(this).is(':checked');
                if (checked) {
                    $(this).parents('.table').find('input[type=checkbox]').prop('checked', true);
                } else {
                    $(this).parents('.table').find('input[type=checkbox]').prop('checked', false);
                }
            });
        },

        // 全选/反选
        function($dom) {
            $dom.find('.group-checkable').each(function() {
                var $this = $(this);
                var $target = $($this.data('target'));

                //如果全部选中，全选checkbox勾上
                $this.prop('checked', true);
                $target.each(function() {
                    if (!$(this).is(':checked')) {
                        $this.prop('checked', false);
                    }
                });

                $(this).click(function() {
                    var checked = $(this).is(':checked');

                    $target.each(function() {
                        if (checked) {
                            $(this).prop('checked', true)
                                .closest('span').addClass('checked') // uniform
                                .closest('tr').addClass('active');
                        } else {
                            $(this).prop('checked', false)
                                .closest('span').removeClass('checked')
                                .closest('tr').removeClass('active');
                        }
                    });
                });

                $target.each(function() {
                    $(this).click(function() {
                        $(this).closest('tr').toggleClass('active');
                    });
                });
            });
        },

        // 表单处理
        function($dom) {
            $dom.find('form').each(function() {
                var $form = $(this);

                $form.find('input').keypress(function(e) {
                    if (e.which == 13) {
                        $form.trigger('submit');
                        return false;
                    }
                });
                // 表单自动验证
                for (var key in vSetting) {
                    var setting = vSetting[key];
                    // ajax 表单处理
                    if ($form.is('.form-ajax')) {
                        setting['submit'] = ajaxSubmitForm;
                    }
                    $form.filter('.validator-' + key).addClass('form-validator').validator(setting);
                }

                // 自动提交搜索表单
                $form.filter('.form-search')
                    .find('select,:checkbox,:radio,.date-picker')
                    .change(function() {
                        $form.trigger('submit');
                    });

                // 绑定提交按钮
                $form.find('input[role=submit],button[role=submit]').off('click').on('click', function() {

                    $form.trigger('submit');
                });
            });
        },

        // AJAX 表单
        function($dom) {
            $dom.find('form.form-ajax').not('.form-validator').submit(ajaxSubmitForm);
        },

        // AJAX LINK
        function($dom) {
            $dom.find('a.ajax-link, a.ajax-delete')
                .off('click').on('click', function(e) {
                    e.preventDefault();

                    var $self = $(this),
                        redirect = $self.data('redirect'),
                        remoteUrl = $self.data('remote') ? $self.data('remote') : $self.attr('href'),
                        message = $self.data('confirm'),
                        ajaxOptions = {
                            url: remoteUrl,
                            dataType: 'json',
                            success: function(data) {
                                ajaxSuccssCallback.call(this, data, redirect);
                            }
                        };

                    if ($self.is('.ajax-delete') && !message) { // 删除链接，需要确认
                        message = 'Are you sure you want to delete this record?';
                    }

                    if (message) {
                        dialog.confirm(message, function(result) {
                            if (result) {
                                $.ajax(ajaxOptions);
                            }
                        });
                    } else {
                        $.ajax(ajaxOptions);
                    }
                });
        },

        // AJAX TABS
        function($dom) {
            $dom.find('.nav-tabs').on('show.bs.tab', function(e) {
                var $link = $(e.target),
                    $pane = $($link.attr('href')),
                    remote = $link.data('remote');

                if (remote) {
                    $pane.ajaxLoadHtml(remote);
                }
            }).find('li:first a').trigger('click');
        },

        // 为 Remote Modal 添加 url 后缀
        function($dom) {
            $dom.find('a,input,button').filter('[data-toggle=modal]').each(function() {
                var $self = $(this),
                    addUrlSuffix = function(url) {
                        if (url == 'undefined' || !url) return '';
                        return url + (url.indexOf('?') === -1 ? '?' : '&') + 'modal=1';
                    };

                if ($self.data('remote')) {
                    $self.data('remote', addUrlSuffix($self.data('remote')));
                } else {
                    $self.attr('href', addUrlSuffix($self.attr('href')));
                }
            });
        },

        // Modal 初始化
        function($dom) {
            $dom.find('.modal').each(function() {
                var $modal = $(this);
                $modal.on('loaded.bs.modal', function() {
                    var $content = $modal.find('.modal-content');
                    if ($content.children().length > 0) {
                        $modal.domInit();
                        // 特地加上 css, display:block, 否则 domInit() 会将对话框重新隐藏
                        // $modal.css('cssText', 'display: block !important');
                    } else {
                        $modal.modal('hide');
                        dialog.error($content.html());
                    }
                });
            });
        },

        // 将 Element 定义 class=ajax-load
        // DomInit 处理后，Element 中的所有链接将会通过 ajax 的方式进行加载
        function($dom) {
            var $ajaxLoad = $dom.is('.ajax-load') ? $dom : $dom.find('.ajax-load');

            if ($ajaxLoad.length === 0) return;

            $ajaxLoad.find('a').not('[href^=javascript]').each(function() {
                var $link = $(this),
                    url = $link.attr('href'),
                    target = $link.attr('target');

                if (target === '_self' || target === 'undefined') {
                    return false;
                }

                $link.off('click').on('click', function(e) {
                    e.preventDefault();

                    $ajaxLoad.ajaxLoadHtml(url);
                });
            });
        }
    ];

    // DOM 初始化
    $.fn.domInit = function() {
        var $dom = $(this);

        for (var i in ONETHING.initEvents) {
            ONETHING.initEvents[i].call(this, $dom);
        }

        return $dom;
    };

    // AJAX 加载 HTML
    $.fn.ajaxLoadHtml = function(url) {
        var $this = $(this);

        $this.html('<center><img src="/image/load.gif" vspace="15" /> Loading ...</center>');

        $.ajax({
            url: url,
            beforeSend: $.noop,
            dataType: 'html',
            error: function() {
                $this.html(
                    '<p class="note note-danger">Load failed, ' +
                    '<a href="javascript:;" class="retry">please try again</a>.</p>'
                ).find('a.retry').click(function() {
                    $this.ajaxLoadHtml(url);
                });
            },
            success: function(html) {
                $this.html(html).domInit();
            }
        });
    };

    // 添加注册初始化方法
    ONETHING.registerInitEvent = function(e) {
        ONETHING.initEvents.push(e);

        // 使 $(document) 加载该事件
        e.call(document, $(document));
    };

});
