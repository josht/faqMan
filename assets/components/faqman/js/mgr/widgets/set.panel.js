faqMan.panel.Set = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2>'+_('faqman')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,defaults: { border: false, autoHeight: true }
            ,border: true
            ,activeItem: 0
            ,hideMode: 'offsets'
            ,items: [{
                title: _('faqman.items')
                ,items: [{
                    html: '<p>'+_('faqman.item_intro_msg')+'</p><br />'
                    ,border:false
                },{
                    xtype: 'faqman-grid-items'
                    ,setid: config.setid
                    ,preventRender: true
                }]
            }]
        }]
    });
    faqMan.panel.Set.superclass.constructor.call(this,config);
};
Ext.extend(faqMan.panel.Set,MODx.Panel);
Ext.reg('faqman-panel-set',faqMan.panel.Set);
