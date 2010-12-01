
faqMan.grid.Items = function(config) {
    config = config || {};

    Ext.applyIf(config,{
        id: 'faqman-grid-items'
        ,url: faqMan.config.connector_url
        ,baseParams: {
            action: 'mgr/item/getlist'
            ,set: config.setid
        }
        ,fields: ['id','question','answer','set','rank']
        ,paging: true
        ,ddGroup: 'mygridDD'
        ,enableDragDrop: true
        ,remoteSort: false
        ,autosave: true
        ,sortInfo: {
            field: 'rank'
            ,direction: 'ASC'
        }
        ,columns: [{/*
            header: _('id')
            ,dataIndex: 'id'
            ,width: 70
        },{*/
            header: _('faqman.question')
            ,dataIndex: 'question'
            ,width: 100
        },{
            header: _('faqman.answer')
            ,dataIndex: 'answer'
            ,width: 300
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
        ,tbar: [{
            text: _('faqman.item_create')
            ,handler: this.createItem
            ,scope: this
        },'->',{
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
        },{
            xtype: 'button'
            ,id: 'modx-filter-clear'
            ,text: _('filter_clear')
            ,listeners: {
                'click': {fn: this.clearFilter, scope: this}
            }
        }]
    });
    faqMan.grid.Items.superclass.constructor.call(this,config);
    this.addEvents('sort');
    this.on('sort',this.onSort,this);
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
    ,_addEnterKeyHandler: function() {
        this.getEl().addKeyListener(Ext.EventObject.ENTER,function() {
            this.fireEvent('change');
        },this);
    }
    ,clearFilter: function() {
        var s = this.getStore();
        s.baseParams.search = '';
        Ext.getCmp('faqman-tf-search').reset();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,search: function(tf,newValue,oldValue) {
        var nv = newValue || tf;
        this.getStore().baseParams.search = nv;
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
        
        if (!this.windows.createItem) {
            this.windows.createItem = MODx.load({
                xtype: 'faqman-window-item-create'
                ,set: s
                ,listeners: {
                    'success': {fn:function() { this.refresh(); },scope:this}
                }
            });
        }
        this.windows.createItem.fp.getForm().reset();
        this.windows.createItem.show(e.target);
    }
    ,updateItem: function(btn,e) {
        if (!this.menu.record || !this.menu.record.id) return false;
        var r = this.menu.record;

        if (!this.windows.updateItem) {
            this.windows.updateItem = MODx.load({
                xtype: 'faqman-window-item-update'
                ,record: r
                ,listeners: {
                    'success': {fn:function() { this.refresh(); },scope:this}
                }
            });
        }
        this.windows.updateItem.fp.getForm().reset();
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
                'success': {fn:function(r) { this.refresh(); },scope:this}
            }
        });
    }
});
Ext.reg('faqman-grid-items',faqMan.grid.Items);


faqMan.window.CreateItem = function(config) {
    config = config || {};
    this.ident = config.ident || 'mecitem'+Ext.id();
    Ext.applyIf(config,{
        title: _('faqman.item_create')
        ,id: this.ident
        ,height: 150
        ,width: 475
        ,url: faqMan.config.connector_url
        ,baseParams: {
            action: 'mgr/item/create'
            ,set: config.set
        }
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('faqman.question')
            ,name: 'question'
            ,id: 'faqman-'+this.ident+'-question'
            ,width: 300
        },{
            xtype: 'textarea'
            ,fieldLabel: _('faqman.answer')
            ,name: 'answer'
            ,id: 'faqman-'+this.ident+'-answer'
            ,width: 300
        }]
    });
    faqMan.window.CreateItem.superclass.constructor.call(this,config);
};
Ext.extend(faqMan.window.CreateItem,MODx.Window);
Ext.reg('faqman-window-item-create',faqMan.window.CreateItem);


faqMan.window.UpdateItem = function(config) {
    config = config || {};
    this.ident = config.ident || 'meuitem'+Ext.id();
    Ext.applyIf(config,{
        title: _('faqman.item_update')
        ,id: this.ident
        ,height: 150
        ,width: 475
        ,url: faqMan.config.connector_url
        ,action: 'mgr/item/update'
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
            ,id: 'faqman-'+this.ident+'-id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('faqman.question')
            ,name: 'question'
            ,id: 'faqman-'+this.ident+'-question'
            ,width: 300
        },{
            xtype: 'textarea'
            ,fieldLabel: _('faqman.answer')
            ,name: 'answer'
            ,id: 'faqman-'+this.ident+'-answer'
            ,width: 300
        }]
    });
    faqMan.window.UpdateItem.superclass.constructor.call(this,config);
};
Ext.extend(faqMan.window.UpdateItem,MODx.Window);
Ext.reg('faqman-window-item-update',faqMan.window.UpdateItem);