Ext.onReady(function() {
    MODx.load({
        xtype: 'faqman-page-set'
        ,setid: faqMan.request.setid
    });
});

faqMan.page.Set = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        buttons: [{
            text: _('faqman.back_to_sets')
            ,id: 'faqman-btn-back'
            ,handler: function() {
                location.href = '?a='+faqMan.request.a+'&action=home';
            }
            ,scope: this
        }]
        ,components: [{
            xtype: 'faqman-panel-set'
            ,renderTo: 'faqman-panel-set-div'
            ,setid: config.setid
        }]
    });
    faqMan.page.Set.superclass.constructor.call(this,config);
};
Ext.extend(faqMan.page.Set,MODx.Component);
Ext.reg('faqman-page-set',faqMan.page.Set);