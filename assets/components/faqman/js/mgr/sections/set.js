Faqman.page.Set = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        buttons: [{
            text: _('faqman.back_to_sets')
            ,id: 'faqman-btn-back'
            ,handler: function() {
                console.log('click: ', Faqman);
                location.href = '?a=index&namespace='+Faqman.request.namespace;
            }
            ,scope: this
        }]
        ,components: [{
            xtype: 'faqman-panel-set'
            ,renderTo: 'faqman-panel-set-div'
            ,setid: config.setid
        }]
    });
    Faqman.page.Set.superclass.constructor.call(this,config);
};
Ext.extend(Faqman.page.Set,MODx.Component);
Ext.reg('faqman-page-set',Faqman.page.Set);
