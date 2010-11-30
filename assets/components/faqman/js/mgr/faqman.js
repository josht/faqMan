var faqMan = function(config) {
    config = config || {};
    faqMan.superclass.constructor.call(this,config);
};
Ext.extend(faqMan,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}
});
Ext.reg('faqman',faqMan);
faqMan = new faqMan();