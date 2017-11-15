require.config({
    map: {
        '*': {
            'css': 'require/require-css/css', // or whatever the path to require-css i
            'datatables.net': 'jquery.dataTables',
            'datatables.net': 'jquery.dataTable.min',
            'datatables.net-buttons': 'jquery.dataTable.min',
            'datatables.net-zf': 'jquery.dataTable.min',
            'datatables.net-se': 'jquery.dataTable.min'
        }
    },
    // js路径
    paths: {
        'jquery': 'plugins/jquery.1.11.0',
        'jquery-ui': 'plugins/jquery-ui',
        'autocomplete': 'plugins/autocomplete.min',
        'bootstrap': 'plugins/bootstrap/js/bootstrap.min',
        'select2': 'plugins/select2/select2',
        'new_common': 'onething/new_common',
        'bootstrap-datepicker': "plugins/bootstrap-datepicker/js/bootstrap-datepicker",
        'datetimepicker': "plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker",
        'jquery.cxselect': "plugins/liandong/jquery.cxselect",
        'echarts': "plugins/echarts/dist/echarts.min",
        'echarts-all': "plugins/echarts-all-3",
        'china': "plugins/china",
        'ckeditor': 'plugins/ckeditor/ckeditor',
        'bootbox': 'plugins/bootbox/bootbox.min',
        'jquery-validator': 'plugins/validator/validator',
        'jquery-form': 'plugins/jquery-form/jquery.form',
        'jquery-cookie': 'plugins/jquery.cookie',
        'jquery.dataTable.min': 'plugins/jquery.dataTables.min',
        'jquery.btn.print': 'plugins/buttons.print.min',
        'jquery.btn.colVis': 'plugins/buttons.colVis.min',
        'jquery.btn.flash': 'plugins/buttons.flash.min',
        'jquery.btn.foundation': 'plugins/buttons.foundation.min',
        'jquery.btn.html5': 'plugins/buttons.html5.min',
        'jquery.btn.semanticui': 'plugins/buttons.semanticui.min',
        'jquery-blockui': 'plugins/jquery.blockui',
        'jquery-slimscroll': 'plugins/jquery-slimscroll/jquery-slimscroll.min',
        'bootstrap-hover-dropdown': 'plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min',
        'zepto': 'plugins/zepto',
        'sm': 'plugins/sm',
        'sm-extend': 'plugins/sm-extend'
    },

    // 依赖 那个js
    shim: {
        'jquery-ui': ['jquery'],
        'autocomplete': ['jquery'],
        'bootstrap': ['jquery'],
        'jquery-form': ['jquery'],
        'bootbox': ['bootstrap'],
        'jquery-validator': ['jquery'],
        'select2': ['jquery'],
        'bootstrap-datepicker': ['jquery'],
        'datetimepicker': ['jquery'],
        'jquery.cxselect': ['jquery'],
        'china': ['echarts-all'],
        'jquery-slimscroll': ['jquery'],
        'jquery.btn.print': ['jquery'],
        'jquery.btn.flash': ['jquery'],
        'jquery.btn.foundation': ['jquery'],
        'jquery.btn.html5': ['jquery'],
        'jquery.btn.semanticui': ['jquery'],
        'jquery.btn.colVis': ['jquery'],
        'bootstrap-hover-dropdown': ['bootstrap'],
        'jquery-blockui': ['jquery']
    },
    waitSeconds: 100 // ie load modules timeout bug fixed
});
