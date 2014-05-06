var faqMan = function(config) {
    config = config || {};
    faqMan.superclass.constructor.call(this,config);
};
Ext.extend(faqMan,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}
});
Ext.reg('faqman',faqMan);
faqMan = new faqMan();

faqMan.combo.PublishStatus = function(config) {
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
    faqMan.combo.PublishStatus.superclass.constructoru.call(this, config);
};
Ext.extend(faqMan.combo.PublishStatus, MODx.combo.ComboBox);
Ext.reg('faq-combo-publish-status', faqMan.combo.PublishStatus);

faqMan.PanelSpacer = { html: '<br />', border: false, cls: 'faq-panel-spacer' };