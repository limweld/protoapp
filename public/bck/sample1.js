/*
This file is part of Ext JS 3.4

Copyright (c) 2011-2013 Sencha Inc

Contact:  http://www.sencha.com/contact

GNU General Public License Usage
This file may be used under the terms of the GNU General Public License version 3.0 as
published by the Free Software Foundation and appearing in the file LICENSE included in the
packaging of this file.

Please review the following information to ensure the GNU General Public License version 3.0
requirements will be met: http://www.gnu.org/copyleft/gpl.html.

If you are unsure which license is appropriate for your use, please contact the sales department
at http://www.sencha.com/contact.

Build date: 2013-04-03 15:07:25
*/


 var store = new Ext.data.JsonStore({
        fields:['name', 'visits', 'views'],
        data: [
            {name:'Jul 07', visits: 245000, views: 3000000},
            {name:'Aug 07', visits: 240000, views: 3500000},
            {name:'Sep 07', visits: 355000, views: 4000000},
            {name:'Oct 07', visits: 375000, views: 4200000},
            {name:'Nov 07', visits: 490000, views: 4500000},
            {name:'Dec 07', visits: 495000, views: 5800000},
            {name:'Jan 08', visits: 520000, views: 6000000},
            {name:'Feb 08', visits: 620000, views: 7500000}
        ]
    });

var store1 = new Ext.data.JsonStore({
        fields: ['season', 'total'],
        data: [{
            season: 'Summer',
            total: 150
        },{
            season: 'Fall',
            total: 245
        },{
            season: 'Winter',
            total: 117
        },{
            season: 'Spring',
            total: 184
        }]
    });

var storeA = new Ext.data.JsonStore({
    root: 'topics',
    totalProperty: 'totalCount',
    idProperty: 'threadid',
    remoteSort: true,

    fields: [
        'title', 'forumtitle', 'forumid', 'author',
        {name: 'replycount', type: 'int'},
        {name: 'lastpost', mapping: 'lastpost', type: 'date', dateFormat: 'timestamp'},
        'lastposter', 'excerpt'
    ],

    proxy: new Ext.data.ScriptTagProxy({
        url: 'http://extjs.com/forum/topics-browse-remote.php'
    })
});

var storeB = Ext.Ajax.request({
    url: 'test/pathmap',
    method : 'POST',
    headers: { 'Content-Type' : 'application/json' },
    argument: { 'test' : '12345' },
    success: function(response, opts) {
        console.log(response);
    },
    failure: function(response, opts) {
        console.log(response);
    }
});



//console.log(storeB.data);

Ext.chart.Chart.CHART_URL = 'resources/charts.swf';

// Sample desktop configuration
MyDesktop = new Ext.app.App({
	init :function(){
		Ext.QuickTips.init();
	},

	getModules : function(){
		return [
			//new MyDesktop.GridWindow(),
            //new MyDesktop.TabWindow(),
            new MyDesktop.SynchDataWindow(),
            //new MyDesktop.AccordionWindow(),
            //new MyDesktop.DashboardsWindow(),
            //new MyDesktop.BogusMenuModule(),
            //new MyDesktop.BogusModule()
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
 * Example windows
 */
MyDesktop.GridWindow = Ext.extend(Ext.app.Module, {
    id:'grid-win',
    init : function(){
        this.launcher = {
            text: 'Grid Window',
            iconCls:'icon-grid',
            handler : this.createWindow,
            scope: this
        }
    },

    createWindow : function(){
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('grid-win');
        if(!win){
            win = desktop.createWindow({
                id: 'grid-win',
                title:'Grid Window',
                width:740,
                height:480,
                iconCls: 'icon-grid',
                shim:false,
                animCollapse:false,
                constrainHeader:true,

                layout: 'fit',
                items:
                    new Ext.grid.GridPanel({
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
                        //autoExpandColumn:'company',

                        tbar:[{
                            text:'Add Something',
                            tooltip:'Add a new row',
                            iconCls:'add'
                        }, '-', {
                            text:'Options',
                            tooltip:'Blah blah blah blaht',
                            iconCls:'option'
                        },'-',{
                            text:'Remove Something',
                            tooltip:'Remove the selected item',
                            iconCls:'remove'
                        }]
                    })
            });
        }
        win.show();
    }
});



MyDesktop.TabWindow = Ext.extend(Ext.app.Module, {
    id:'tab-win',
    init : function(){
        this.launcher = {
            text: 'Tab Window',
            iconCls:'tabs',
            handler : this.createWindow,
            scope: this
        }
    },

    createWindow : function(){
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('tab-win');
        if(!win){
            win = desktop.createWindow({
                id: 'tab-win',
                title:'Tab Window',
                width:740,
                height:480,
                iconCls: 'tabs',
                shim:false,
                animCollapse:false,
                border:false,
                constrainHeader:true,

                layout: 'fit',
                items:
                    new Ext.TabPanel({
                        activeTab:0,

                        items: [{
                            title: 'Tab Text 1',
                            header:false,
                            html : '<p>Something useful would be in here.</p>',
                            border:false
                        },{
                            title: 'Tab Text 2',
                            header:false,
                            html : '<p>Something useful would be in here.</p>',
                            border:false
                        },{
                            title: 'Tab Text 3',
                            header:false,
                            html : '<p>Something useful would be in here.</p>',
                            border:false
                        },{
                            title: 'Tab Text 4',
                            header:false,
                            html : '<p>Something useful would be in here.</p>',
                            border:false
                        }]
                    })
            });
        }
        win.show();
    }
});



MyDesktop.AccordionWindow = Ext.extend(Ext.app.Module, {
    id:'acc-win',
    init : function(){
        this.launcher = {
            text: 'Accordion Window',
            iconCls:'accordion',
            handler : this.createWindow,
            scope: this
        }
    },

    createWindow : function(){
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('acc-win');
        if(!win){
            win = desktop.createWindow({
                id: 'acc-win',
                title: 'Accordion Window',
                width:250,
                height:400,
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

                layout:'accordion',
                border:false,
                layoutConfig: {
                    animate:false
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
                    }), {
                        title: 'Settings',
                        html:'<p>Something useful would be in here.</p>',
                        autoScroll:true
                    },{
                        title: 'Even More Stuff',
                        html : '<p>Something useful would be in here.</p>'
                    },{
                        title: 'My Stuff',
                        html : '<p>Something useful would be in here.</p>'
                    }
                ]
            });
        }
        win.show();
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
                        //{
                        // html: Ext.example.shortBogusMarkup,
                        //    title:'Navigation',
                        //    autoScroll:true,
                        //    border:false,
                        //    iconCls:'nav'
                        // }
                        // ,{
                        //     title:'Settings',
                        //     // html: Ext.example.shortBogusMarkup,
                        //     border:false,
                        //     autoScroll:true,
                        //     iconCls:'settings'
                        // }
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


 MyDesktop.DashboardsWindow = Ext.extend(Ext.app.Module, {
    id:'dashboards-win',
    init : function(){
        this.launcher = {
            text: 'Dashboards',
            iconCls:'accordion',
            handler : this.createWindow,
            scope: this
        }
    },

    createWindow : function(){
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('dashboards-win');

        if(!win){
            win = desktop.createWindow({
                id: 'dashboards-win',
                title: 'Dashboard',
                width:1200,
                height:450,
                iconCls: 'accordion',
                shim:false,
                animCollapse:false,
                constrainHeader:true,   
                layout:'border',
                border:false,
                layoutConfig: {
                    animate:false
                },
                items:[{
                        region:'west',
                        id:'west-panel',
                        //title:'Chart A',
                        width: 400,
                        //layout:'accordion',
                        items: new Ext.Panel({
                            title: 'ExtJS.com Visits Trend, 2007/2008 (No styling)',
                            //renderTo: 'container',
                            // width:500,
                             height:400,
                             layout:'fit',
                    
                            items: {
                                xtype: 'linechart',
                                store: store,
                                xField: 'name',
                                yField: 'visits',
                                listeners: {
                                    itemclick: function(o){
                                        var rec = store.getAt(o.index);
                                        Ext.example.msg('Item Selected', 'You chose {0}.', rec.get('name'));
                                    }
                                }
                            }
                        })
                    },
                    {
                        region:'center',
                        id:'center-panel',
                        //title:'Chart B',
                        //split:true,
                        width: 400,
                        // minSize: 175,
                        // maxSize: 400,
                        //collapsible: true,
                        //layout:'accordion',
                        // layoutConfig:{
                        //     animate:true
                        // },
                        items:     new Ext.Panel({
                            width: 400,
                            height: 400,
                            title: 'Pie Chart with Legend - Favorite Season',
                            //renderTo: 'container',
                            items: {
                                store: store1,
                                xtype: 'piechart',
                                dataField: 'total',
                                categoryField: 'season',
                                //extra styles get applied to the chart defaults
                                extraStyle:
                                {
                                    legend:
                                    {
                                        display: 'bottom',
                                        padding: 5,
                                        font:
                                        {
                                            family: 'Tahoma',
                                            size: 13
                                        }
                                    }
                                }
                            }
                        })
                    },
                    {
                        region:'east',
                        id:'east-panel',
                        title:'Chart C  ',
                        //  split:true,
                        width: 400,
                        // minSize: 175,
                        // maxSize: 400,
                        //collapsible: true,
                        layout:'accordion',
                        // layoutConfig:{
                        //     animate:true
                        // },
                        items: []
                    },

                ]
            });
        }   
        win.show();
    }
 });


/*
|------------------------------------------------------------------------------------------------
| Practice End Module
|------------------------------------------------------------------------------------------------
*/

// for example purposes
var windowIndex = 0;

MyDesktop.BogusModule = Ext.extend(Ext.app.Module, {
    init : function(){
        this.launcher = {
            text: 'Window '+(++windowIndex),
            iconCls:'bogus',
            handler : this.createWindow,
            scope: this,
            windowId:windowIndex
        }
    },

    createWindow : function(src){
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('bogus'+src.windowId);
        if(!win){
            win = desktop.createWindow({
                id: 'bogus'+src.windowId,
                title:src.text,
                width:640,
                height:480,
                html : '<p>Something useful would be in here.</p>',
                iconCls: 'bogus',
                shim:false,
                animCollapse:false,
                constrainHeader:true
            });
        }
        win.show();
    }
});


MyDesktop.BogusMenuModule = Ext.extend(MyDesktop.BogusModule, {
    init : function(){
        this.launcher = {
            text: 'Bogus Submenu',
            iconCls: 'bogus',
            handler: function() {
				return false;
			},
            menu: {
                items:[{
                    text: 'Bogus Window '+(++windowIndex),
                    iconCls:'bogus',
                    handler : this.createWindow,
                    scope: this,
                    windowId: windowIndex
                    },{
                    text: 'Bogus Window '+(++windowIndex),
                    iconCls:'bogus',
                    handler : this.createWindow,
                    scope: this,
                    windowId: windowIndex
                    },{
                    text: 'Bogus Window '+(++windowIndex),
                    iconCls:'bogus',
                    handler : this.createWindow,
                    scope: this,
                    windowId: windowIndex
                    },{
                    text: 'Bogus Window '+(++windowIndex),
                    iconCls:'bogus',
                    handler : this.createWindow,
                    scope: this,
                    windowId: windowIndex
                    },{
                    text: 'Bogus Window '+(++windowIndex),
                    iconCls:'bogus',
                    handler : this.createWindow,
                    scope: this,
                    windowId: windowIndex
                }]
            }
        }
    }
});


// Array data for the grid
Ext.grid.dummyData = [
    ['3m Co',71.72,0.02,0.03,'9/1 12:00am'],
    ['Alcoa Inc',29.01,0.42,1.47,'9/1 12:00am'],
    ['American Express Company',52.55,0.01,0.02,'9/1 12:00am'],
    ['American International Group, Inc.',64.13,0.31,0.49,'9/1 12:00am'],
    ['AT&T Inc.',31.61,-0.48,-1.54,'9/1 12:00am'],
    ['Caterpillar Inc.',67.27,0.92,1.39,'9/1 12:00am'],
    ['Citigroup, Inc.',49.37,0.02,0.04,'9/1 12:00am'],
    ['Exxon Mobil Corp',68.1,-0.43,-0.64,'9/1 12:00am'],
    ['General Electric Company',34.14,-0.08,-0.23,'9/1 12:00am'],
    ['General Motors Corporation',30.27,1.09,3.74,'9/1 12:00am'],
    ['Hewlett-Packard Co.',36.53,-0.03,-0.08,'9/1 12:00am'],
    ['Honeywell Intl Inc',38.77,0.05,0.13,'9/1 12:00am'],
    ['Intel Corporation',19.88,0.31,1.58,'9/1 12:00am'],
    ['Johnson & Johnson',64.72,0.06,0.09,'9/1 12:00am'],
    ['Merck & Co., Inc.',40.96,0.41,1.01,'9/1 12:00am'],
    ['Microsoft Corporation',25.84,0.14,0.54,'9/1 12:00am'],
    ['The Coca-Cola Company',45.07,0.26,0.58,'9/1 12:00am'],
    ['The Procter & Gamble Company',61.91,0.01,0.02,'9/1 12:00am'],
    ['Wal-Mart Stores, Inc.',45.45,0.73,1.63,'9/1 12:00am'],
    ['Walt Disney Company (The) (Holding Company)',29.89,0.24,0.81,'9/1 12:00am']
];