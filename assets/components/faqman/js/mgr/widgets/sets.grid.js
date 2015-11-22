
faqMan.grid.Sets = function(config) {
    config = config || {};
    var gridView = new Ext.grid.GridView({
        forceFit: true
        ,scrollOffset: 0
        ,getRowClass : function (row, index) {
            var cls = '';
            var data = row.data;

            if (data.published == 0) {
                cls = 'faqman-grid-set-unpublished'; // highlight row red
            }

            return cls;
        }
    });  //end gridView

    Ext.applyIf(config,{
        id: 'faqman-grid-sets'
        ,url: faqMan.config.connector_url
        ,baseParams: {
            action: 'mgr/set/getlist'
        }
        ,fields: ['id','name','description','rank', 'published']
        ,autoHeight: true
        ,paging: true
        ,ddGroup: 'mygridDD'
        ,enableDragDrop: true
        ,remoteSort: true
        ,view: gridView
        ,columns: [
            {
                header: _('id')
                ,dataIndex: 'id'
                ,width: 20
            }
            ,{
                header: _('name')
                ,dataIndex: 'name'
                ,width: 200
            }
            ,{
                header: _('description')
                ,dataIndex: 'description'
                ,width: 250
            }
        ]
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
                            rows   = sm.getSelections();

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
            text: _('faqman.set_create')
            ,handler: this.createSet
            ,scope: this
        }]
    });
    faqMan.grid.Sets.superclass.constructor.call(this,config);
    this.addEvents('sort');
    this.on('sort',this.onSort,this);
};
Ext.extend(faqMan.grid.Sets,MODx.grid.Grid,{
    windows: {}

    ,onSort: function(o) {
        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'mgr/set/sort'
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
    ,getMenu: function() {
        var record = this.menu.record;
        var m = [];
        m.push({
            text: _('faqman.set_manage')
            ,handler: this.manageSet
        });
        m.push({
            text: _('faqman.set_update')
            ,handler: this.updateSet
        });

        if (record.published) {
            m.push({
                text: _('faqman.unpublish')
                ,handler: this.unpublishSet
            });

        } else {
            m.push({
                text: _('faqman.publish')
                ,handler: this.publishSet
            });
        }

        m.push('-');
        m.push({
            text: _('faqman.set_remove')
            ,handler: this.removeSet
        });
        this.addContextMenuItem(m);
    }

    ,manageSet: function() {
        var redir = '?a='+MODx.request.a+'&action=set&setid=';

        // needed for double click
        if (typeof(this.menu.record) == "undefined") {
            redir += this.getSelectedAsList();
        } else {
            redir += this.menu.record.id;
        }
        location.href = redir;
    }

    ,createSet: function(btn,e) {
        if (!this.windows.createSet) {
            this.windows.createSet = MODx.load({
                xtype: 'faqman-window-set-create'
                ,listeners: {
                    'success': {fn:function() {this.refresh();},scope:this}
                }
            });
        }
        this.windows.createSet.fp.getForm().reset();
        this.windows.createSet.show(e.target);
    }

    ,updateSet: function(btn,e) {
        if (!this.menu.record || !this.menu.record.id) return false;
        var r = this.menu.record;

        if (!this.windows.updateSet) {
            this.windows.updateSet = MODx.load({
                xtype: 'faqman-window-set-update'
                ,record: r
                ,listeners: {
                    'success': {fn:function() {this.refresh();},scope:this}
                }
            });
        }
        this.windows.updateSet.fp.getForm().reset();
        this.windows.updateSet.fp.getForm().setValues(r);
        this.windows.updateSet.show(e.target);
    }

    ,publishSet: function(btn, e) {
        if (!this.menu.record) return false;

        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'mgr/set/publish'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success':{fn:function(r) {
                    this.refresh();
                }, scope:this}
            }
        });
    }

    ,unpublishSet: function(btn, e) {
        if (!this.menu.record) return false;

        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'mgr/set/unpublish'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success':{fn:function(r) {
                    this.refresh();
                }, scope:this}
            }
        });
    }

    ,removeSet: function(btn,e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: _('faqman.set_remove')
            ,text: _('faqman.set_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/set/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:function(r) {this.refresh();},scope:this}
            }
        });
    }
});
Ext.reg('faqman-grid-sets',faqMan.grid.Sets);


faqMan.window.CreateSet = function(config) {
    config = config || {};
    this.ident = config.ident || 'mecset'+Ext.id();
    Ext.applyIf(config,{
        title: _('faqman.set_create')
        ,id: this.ident
        ,autoHeight: true
        ,width: 475
        ,modal: true
        ,url: faqMan.config.connector_url
        ,action: 'mgr/set/create'
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('name')
            ,name: 'name'
            ,id: 'faqman-'+this.ident+'-name'
            ,width: 300
        },{
            xtype: 'textarea'
            ,fieldLabel: _('description')
            ,name: 'description'
            ,id: 'faqman-'+this.ident+'-description'
            ,width: 300
        }]
    });
    faqMan.window.CreateSet.superclass.constructor.call(this,config);
};
Ext.extend(faqMan.window.CreateSet,MODx.Window);
Ext.reg('faqman-window-set-create',faqMan.window.CreateSet);

faqMan.window.UpdateSet = function(config) {
    config = config || {};
    this.ident = config.ident || 'meuset'+Ext.id();
    Ext.applyIf(config,{
        title: _('faqman.set_update')
        ,id: this.ident
        ,autoHeight: true
        ,width: 475
        ,modal: true
        ,url: faqMan.config.connector_url
        ,action: 'mgr/set/update'
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
            ,id: 'faqman-'+this.ident+'-id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('name')
            ,name: 'name'
            ,id: 'faqman-'+this.ident+'-name'
            ,width: 300
        },{
            xtype: 'textarea'
            ,fieldLabel: _('description')
            ,name: 'description'
            ,id: 'faqman-'+this.ident+'-description'
            ,width: 300
        }]
    });
    faqMan.window.UpdateSet.superclass.constructor.call(this,config);
};
Ext.extend(faqMan.window.UpdateSet,MODx.Window);
Ext.reg('faqman-window-set-update',faqMan.window.UpdateSet);

