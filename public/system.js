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