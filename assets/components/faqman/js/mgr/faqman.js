var Faqman = function(config) {
    config = config || {};
    Faqman.superclass.constructor.call(this,config);
};
Ext.extend(Faqman,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}
});
Ext.reg('faqman',Faqman);
Faqman = new Faqman();

Faqman.combo.PublishStatus = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: [[1, _('published')], [0, _('unpublished')]]
        ,name: 'published'
        ,hiddenName: 'published'
        ,triggerAction: 'all'
        ,editable: false
        ,selectOnFocus: false
        ,preventRender: true
        ,forceSelection: true
        ,enableKeyEvents: true
    });
    Faqman.combo.PublishStatus.superclass.constructor.call(this, config);
};
Ext.extend(Faqman.combo.PublishStatus, MODx.combo.ComboBox);
Ext.reg('faq-combo-publish-status', Faqman.combo.PublishStatus);

Faqman.PanelSpacer = { html: '<br />', border: false, cls: 'faq-panel-spacer' };
