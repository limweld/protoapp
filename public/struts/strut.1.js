
var modal = document.getElementById('loginModal');
modal.style.display = "block";

MyDesktop = new Ext.app.App({
    init :function(){
        Ext.QuickTips.init();
    },

    getModules : function(){
        return [
            new MyDesktop.SynchDataWindow(),
        ];
    },

    // config for the start menu
    getStartConfig : function(){
        return {
            title: 'Jack Slocum',
            iconCls: 'user',
            toolItems: [{
                text:'Settings',
                iconCls:'settings',
                scope:this
            },'-',{
                text:'Logout',
                iconCls:'logout',
                scope:this
            }]
        };
    }
});



/*
|------------------------------------------------------------------------------------------------
|  Practice
|------------------------------------------------------------------------------------------------
*/

MyDesktop.SynchDataWindow = Ext.extend(Ext.app.Module, {
id:'synch-win',
init : function(){
    this.launcher = {
        text: 'Synch Data',
        iconCls:'accordion',
        handler : this.createWindow,
        scope: this
    }
},

createWindow : function(){
    var desktop = this.app.getDesktop();
    var win = desktop.getWindow('synch-win');

    if(!win){
        win = desktop.createWindow({
            id: 'synch-win',
            title: 'Sync From Slave',
            width:1250,
            height:500,
            iconCls: 'accordion',
            shim:false,
            animCollapse:false,
            constrainHeader:true,
            tbar:[{
                tooltip:{title:'Rich Tooltips', text:'Let your users know what they can do!'},
                iconCls:'connect'
            },'-',{
                tooltip:'Add a new user',
                iconCls:'user-add'
            },' ',{
                tooltip:'Remove the selected user',
                iconCls:'user-delete'
            }],
            layout:'border',
            border:false,
            layoutConfig: {
                animate:false
            },
            items:[{
                    region:'west',
                    id:'west-panel',
                    title:'Pathmap',
                    split:true,
                    width: 200,
                    minSize: 175,
                    maxSize: 400,
                    collapsible: true,
                    layout:'accordion',
                    layoutConfig:{
                        animate:true
                    },
                    items: [
                    
                        
                            new Ext.tree.TreePanel({
                                id:'im-tree',
                                title: 'Online Users',
                                loader: new Ext.tree.TreeLoader(),
                                rootVisible:false,
                                lines:false,
                                autoScroll:true,
                                tools:[{
                                    id:'refresh',
                                    on:{
                                        click: function(){
                                            var tree = Ext.getCmp('im-tree');
                                            tree.body.mask('Loading', 'x-mask-loading');
                                            tree.root.reload();
                                            tree.root.collapse(true, false);
                                            setTimeout(function(){ // mimic a server call
                                                tree.body.unmask();
                                                tree.root.expand(true, true);
                                            }, 1000);
                                        }
                                    }
                                }],
                                root: new Ext.tree.AsyncTreeNode({
                                    text:'Online',
                                    children:[{
                                        text:'Friends',
                                        expanded:true,
                                        children:[{
                                            text:'Jack',
                                            iconCls:'user',
                                            leaf:true
                                        },{
                                            text:'Brian',
                                            iconCls:'user',
                                            leaf:true
                                        },{
                                            text:'Jon',
                                            iconCls:'user',
                                            leaf:true
                                        },{
                                            text:'Tim',
                                            iconCls:'user',
                                            leaf:true
                                        },{
                                            text:'Nige',
                                            iconCls:'user',
                                            leaf:true
                                        },{
                                            text:'Fred',
                                            iconCls:'user',
                                            leaf:true
                                        },{
                                            text:'Bob',
                                            iconCls:'user',
                                            leaf:true
                                        }]
                                    },{
                                        text:'Family',
                                        expanded:true,
                                        children:[{
                                            text:'Kelly',
                                            iconCls:'user-girl',
                                            leaf:true
                                        },{
                                            text:'Sara',
                                            iconCls:'user-girl',
                                            leaf:true
                                        },{
                                            text:'Zack',
                                            iconCls:'user-kid',
                                            leaf:true
                                        },{
                                            text:'John',
                                            iconCls:'user-kid',
                                            leaf:true
                                        }]
                                    }]
                                })
                            }) 
                ]
                },{
                    region:'center',
                    layout:'fit',
                    title:'Pathmap',
                    autoScroll:true,
                    items: new Ext.grid.GridPanel({
                        border:false,
                        ds: new Ext.data.Store({
                            reader: new Ext.data.ArrayReader({}, [
                               {name: 'company'},
                               {name: 'price', type: 'float'},
                               {name: 'change', type: 'float'},
                               {name: 'pctChange', type: 'float'}
                            ]),
                            data: Ext.grid.dummyData
                        }),
                        cm: new Ext.grid.ColumnModel([
                            new Ext.grid.RowNumberer(),
                            {header: "Company", width: 120, sortable: true, dataIndex: 'company'},
                            {header: "Price", width: 70, sortable: true, renderer: Ext.util.Format.usMoney, dataIndex: 'price'},
                            {header: "Change", width: 70, sortable: true, dataIndex: 'change'},
                            {header: "% Change", width: 70, sortable: true, dataIndex: 'pctChange'}
                        ]),

                        viewConfig: {
                            forceFit:true
                        },
                        bbar: new Ext.PagingToolbar({
                            pageSize: 25,
                            //store: store,
                            displayInfo: true,
                            displayMsg: 'Displaying topics {0} - {1} of {2}',
                            emptyMsg: "No topics to display",
                            items:[
                                '-', {
                                pressed: true,
                                enableToggle:true,
                                text: 'Sync To Dev',
                                //cls: 'x-btn-text-icon details',
                                toggleHandler: function(btn, pressed){
                                    var view = grid.getView();
                                    view.showPreview = pressed;
                                    view.refresh();
                            }
                        }]
                    })      
                }),
            }]
        });
    }   
    win.show();
    }
});

