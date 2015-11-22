faqMan.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>'+_('faqman')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-panel'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,activeItem: 0
            ,hideMode: 'offsets'
            ,items: [{
                title: _('faqman.sets')
                ,items: [{
                    html: '<p>'+_('faqman.set_intro_msg')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'faqman-grid-sets'
                    ,preventRender: true
                    ,cls: 'main-wrapper'
                }]
            }]
        }]
    });
    faqMan.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(faqMan.panel.Home,MODx.Panel);
Ext.reg('faqman-panel-home',faqMan.panel.Home);
