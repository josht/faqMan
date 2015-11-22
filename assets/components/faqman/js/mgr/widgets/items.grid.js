faqMan.grid.Items = function(config) {
    config = config || {};

    this.exp = new Ext.grid.RowExpander({
        tpl: new Ext.Template(
            '<p class="answer">{answer}</p>'
        )
    });

    Ext.applyIf(config,{
        id: 'faqman-grid-items'
        ,url: faqMan.config.connector_url
        ,baseParams: {
            action: 'mgr/item/getlist'
            ,set: config.setid
        }
        ,fields: ['id', 'question', 'answer', 'set', 'rank', 'actions']
        ,paging: true
        ,ddGroup: 'mygridDD'
        ,enableDragDrop: true
        ,remoteSort: false
        ,cls: 'faq-grid'
        ,bodyCssClass: 'grid-with-buttons'
        ,autosave: true
        ,preventRender: true
        ,autoExpandColumn: 'answer'
        ,plugins: [this.exp]
        ,viewConfig: {
            forceFit:true
            ,enableRowBody:true
            ,showPreview:true
            ,getRowClass: this.applyRowClass
            ,scrollOffset: 0
        }
        ,sortInfo: {
            field: 'rank'
            ,direction: 'ASC'
        }
        ,columns: [this.exp, {
            header: _('faqman.question')
            ,dataIndex: 'question'
            ,renderer: {fn:this._renderQuestion, scope: this}
        }]
        ,listeners: {
            "render": {
                scope: this
                ,fn: function(grid) {
                    var ddrow = new Ext.dd.DropTarget(grid.container, {
                        ddGroup: 'mygridDD'
                        ,copy: false
                        ,notifyDrop: function(dd, e, data) { // thing being dragged, event, data from dagged source
                            var ds = grid.store;
                            var sm = grid.getSelectionModel();
                            rows = sm.getSelections();

                            if (dd.getDragData(e)) {
                                var targetNode = dd.getDragData(e).selections[0];
                                var sourceNode = data.selections[0];

                                grid.fireEvent('sort',{
                                    target: targetNode
                                    ,source: sourceNode
                                    ,event: e
                                    ,dd: dd
                                });
                            }
                        }
                    });
                }
            }
        }
        ,tbar: [
            {
                text: _('faqman.item_create')
                ,handler: this.createItem
                ,scope: this
            }
            ,'->'
            ,{
                xtype: 'textfield'
                ,name: 'search'
                ,id: 'faqman-tf-search'
                ,emptyText: _('search')+'...'
                ,listeners: {
                    'change': {fn: this.search, scope: this}
                    ,'render': {fn: function(cmp) {
                        new Ext.KeyMap(cmp.getEl(), {
                            key: Ext.EventObject.ENTER
                            ,fn: function() {
                                this.fireEvent('change',this.getValue());
                                this.blur();
                                return true;}
                            ,scope: cmp
                        });
                    },scope:this}
                }
            }
            ,'-'
            ,{
                xtype: 'button'
                ,id: 'modx-filter-clear'
                ,text: _('filter_clear')
                ,listeners: {
                    'click': {fn: this.clearFilter, scope: this}
                }
            }
        ]
    });
    faqMan.grid.Items.superclass.constructor.call(this,config);
    this._makeTemplate();
    this.addEvents('sort');
    this.on('sort',this.onSort,this);
    this.on('click', this.handleButtons, this);
};
Ext.extend(faqMan.grid.Items,MODx.grid.Grid,{
    windows: {}

    ,onSort: function(o) {
        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'mgr/item/sort'
                ,set: this.config.setid
                ,source: o.source.id
                ,target: o.target.id
            }
            ,listeners: {
                'success':{fn:function(r) {
                        this.refresh();
                },scope:this}
            }
        });
    }

    ,_makeTemplate: function() {
        this.tplQuestion = new Ext.XTemplate('<tpl for="."><div class="faq-question-column">'
                                            +'<h3 class="main-column"><a href="{action_edit}" title="Edit {question}">{question}</a><span class="question-id">({id})</span></h3>'
                                                +'<tpl if="actions">'
                                                    +'<ul class="actions">'
                                                        +'<tpl for="actions">'
                                                            +'<li><a href="#" class="controlBtn {className}">{text}</a></li>'
                                                        +'</tpl>'
                                                    +'</ul>'
                                                +'</tpl>'
                                            +'</div></tpl>', {
            compiled: true
        });
    }

    ,applyRowClass: function(record, rowIndex, p, ds) {
        if (this.grid.viewConfig.showPreview) {
            var xf = Ext.util.Format;
            p.body = '<p>' + xf.ellipsis(xf.stripTags(record.data.answer), 300) + '</p>';
            return 'x-grid3-row-expanded';
        }
        return 'x-grid3-row-collapsed';
    }
    ,clearFilter: function() {
        var s = this.getStore();
        s.baseParams.search = '';
        Ext.getCmp('faqman-tf-search').reset();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,search: function(tf,newValue,oldValue) {
        this.getStore().baseParams.search = newValue || tf;
        this.getBottomToolbar().changePage(1);
        this.refresh();
        return true;
    }
    ,getMenu: function() {
        var m = [];
        m.push({
            text: _('faqman.item_update')
            ,handler: this.updateItem
        });
        m.push('-');
        m.push({
            text: _('faqman.item_remove')
            ,handler: this.removeItem
        });
        this.addContextMenuItem(m);
    }

    ,createItem: function(btn,e) {
        if (!this.config || !this.config.setid) return false;
        var s = this.config.setid;

        this.windows.createItem = MODx.load({
            xtype: 'faqman-window-item-create'
            ,set: s
            ,listeners: {
                'success': {fn:function() {this.refresh();},scope:this}
            }
        });
        this.windows.createItem.show(e.target);
    }

    ,updateItem: function(btn,e) {
        if (!this.menu.record || !this.menu.record.id) return false;
        var r = this.menu.record;

        this.windows.updateItem = MODx.load({
            xtype: 'faqman-window-item-update'
            ,record: r
            ,listeners: {
                'success': {fn:function() {this.refresh();},scope:this}
            }
        });
        this.windows.updateItem.fp.getForm().setValues(r);
        this.windows.updateItem.show(e.target);
    }

    ,removeItem: function(btn,e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: _('faqman.item_remove')
            ,text: _('faqman.item_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/item/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:function(r) {this.refresh();},scope:this}
            }
        });
    }

    ,_renderQuestion: function(value, p, record) {
        return this.tplQuestion.apply(record.data);
    }
    ,publishItem: function() {
        MODx.Ajax.request({
            url: faqMan.config.connector_url
            ,params: {
                action: 'mgr/item/publish'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn: this.refresh, scope: this}
            }
        });
        return true;

    }
    ,unpublishItem: function(record) {
        MODx.Ajax.request({
            url: faqMan.config.connector_url
            ,params: {
                action: 'mgr/item/unpublish'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn: this.refresh, scope: this}
            }
        });
        return true;
    }

    ,handleButtons: function(e) {
        var target  = e.getTarget();
        var element = target.className.split(' ')[0];
        if (element == 'controlBtn') {
            var action       = target.className.split(' ')[1];
            var record       = this.getSelectionModel().getSelected().data;
            this.menu.record = record;
            switch (action) {
                case 'edit':
                    this.updateItem(null, e);
                    break;
                case 'publish':
                    this.publishItem();
                    break;
                case 'unpublish':
                    this.unpublishItem();
                    break;
                case 'delete':
                    this.removeItem();
                    break;
                default:
                    break;
            }
        }
    }
});
Ext.reg('faqman-grid-items',faqMan.grid.Items);


faqMan.window.CreateItem = function(config) {
    config = config || {};
    this.ident = config.ident || 'mecitem'+Ext.id();
    Ext.applyIf(config,{
        title: _('faqman.item_create')
        ,id: this.ident
        ,autoHeight: true
        ,width: 650
        ,modal: true
        ,url: faqMan.config.connector_url
        ,closeAction: 'close'
        ,baseParams: {
            action: 'mgr/item/create'
            ,set: config.set
        }
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('faqman.question')
            ,name: 'question'
            ,id: 'faqman-'+this.ident+'-question'
            ,width: '94%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('faqman.answer')
            ,name: 'answer'
            ,id: 'faqman-'+this.ident+'-answer'
            ,width: '94%'
            ,height: 250
        }],
        keys: [] //Prevent enter key from submitting the form
    });
    faqMan.window.CreateItem.superclass.constructor.call(this,config);
    this.on('activate',function() {
        if (MODx.loadRTE) { MODx.loadRTE('faqman-'+this.ident+'-answer'); }
    });
};
Ext.extend(faqMan.window.CreateItem,MODx.Window);
Ext.reg('faqman-window-item-create',faqMan.window.CreateItem);


faqMan.window.UpdateItem = function(config) {
    config = config || {};
    this.ident = config.ident || 'meuitem'+Ext.id();
    Ext.applyIf(config,{
        title: _('faqman.item_update')
        ,id: this.ident
        ,autoHeight: true
        ,width: 650
        ,modal: true
        ,url: faqMan.config.connector_url
        ,action: 'mgr/item/update'
        ,closeAction: 'close'
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
            ,id: 'faqman-'+this.ident+'-id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('faqman.question')
            ,name: 'question'
            ,id: 'faqman-'+this.ident+'-question'
            ,width: '94%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('faqman.answer')
            ,name: 'answer'
            ,id: 'faqman-'+this.ident+'-answer'
            ,width: '94%'
            ,height: 250
        }],
        keys: [] //Prevent enter key from submitting the form
    });
    faqMan.window.UpdateItem.superclass.constructor.call(this,config);
    this.on('activate',function() {
        if (MODx.loadRTE) { MODx.loadRTE('faqman-'+this.ident+'-answer'); }
    });
};
Ext.extend(faqMan.window.UpdateItem,MODx.Window);
Ext.reg('faqman-window-item-update',faqMan.window.UpdateItem);

