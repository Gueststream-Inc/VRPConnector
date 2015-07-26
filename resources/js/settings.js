(function($, global, undefined){
    /* Handles */
    $(function() {
        $("div[data-list-name='documentation-list'] > a.list-group-item").click(function(){
            $("div[data-list-name='documentation-list']").children('a.list-group-item').removeClass('active');
            $(this).addClass('active');
        });
        $('select[name=vrpPluginMode]').change(function(){
            var that = $(this);
            if(that.val() === 'live') {
                $('input[name=vrpAPI]').parents().eq(1).fadeIn();
            } else if(that.val() === 'developer') {
                var formData = $('form[name=vrpAPISettings]').serialize();
                $('form[name=vrpAPISettings]').submit();
            }
        });
        $('a[data-theme-selection]').click(function(){
            var that = $(this),
                form = $('form[name=vrpThemeSelection]'),
                selectedTheme = that.data('theme-selection');

            $('input[name=vrpTheme]').val(selectedTheme);
            form.submit();
        });
    });
}(jQuery, window));