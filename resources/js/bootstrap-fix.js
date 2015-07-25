var bootstrapCss = 'bootstrapCss';

if (!document.getElementById(bootstrapCss))
{
    var head = document.getElementsByTagName('head')[0];
    var bootstrap = document.createElement('link');
    bootstrap.id = bootstrapCss;
    bootstrap.rel = 'stylesheet/less';
    bootstrap.type = 'text/css';
    bootstrap.href = '../wp-content/plugins/vrpconnector/resources/less/bootstrap-wrapper.less';
    bootstrap.media = 'all';
    head.appendChild(bootstrap);

    var fontAwesome = document.createElement('link');
    fontAwesome.rel = 'stylesheet/less';
    fontAwesome.type = 'text/css';
    fontAwesome.href = '../wp-content/plugins/vrpconnector/resources/bower/font-awesome/less/font-awesome.less';
    fontAwesome.media = 'all';
    head.appendChild(fontAwesome);

    var lessjs = document.createElement('script');
    lessjs.type = 'text/javascript';
    lessjs.src = '../wp-content/plugins/vrpconnector/resources/bower/less/dist/less.min.js';
    head.appendChild(lessjs);
}