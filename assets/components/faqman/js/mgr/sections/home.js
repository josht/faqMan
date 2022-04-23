Faqman.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'faqman-panel-home'
            ,renderTo: 'faqman-panel-home-div'
        }]
    });
    Faqman.page.Home.superclass.constructor.call(this,config);

};
Ext.extend(Faqman.page.Home,MODx.Component);
Ext.reg('faqman-page-home',Faqman.page.Home);
