Ext.onReady(function() {
    MODx.load({ xtype: 'faqman-page-home'});
});

faqMan.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'faqman-panel-home'
            ,renderTo: 'faqman-panel-home-div'
        }]
    }); 
    faqMan.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(faqMan.page.Home,MODx.Component);
Ext.reg('faqman-page-home',faqMan.page.Home);