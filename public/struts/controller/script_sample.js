Ext.define('script_sample.controller.script_sample', {
    extend : 'Ext.app.Controller',
    models : ['School.model.Student'],
    views : ['School.view.StudentMaster'],
    refs : [{
        ref : 'studentMasterForm',
        selector : 'viewport > StudentMaster'
    }],
    init : function(){
        this.control({
            'viewport > StudentMaster button[itemId=btnCreate]' : 
            {
                click : this.onCreateClick
            },
            'viewport > StudentMaster button[itemId=btnUpdate]' : 
            {
                click : this.onUpdateClick
            },
            'viewport > StudentMaster button[itemId=btnDelete]' : 
            {
                click : this.onDeleteClick
            },
            'viewport > StudentMaster button[itemId=btnLoad]' : 
            {
                click : this.onLoadClick
            },
            'viewport > StudentMaster button[itemId=btnReset]' : 
            {
                click : this.onResetClick
            },
            'viewport > StudentMaster button[itemId=btnClear]' : 
            {
                click : this.onClearClick
            }
        });
    },
    onCreateClick : function(){
        var stdMaster = this.getStudentMasterForm();
        
        if( ! stdMaster.isDirty()){
            Ext.Msg.alert('Status', 'No new data to create.');
            return;
        }
        else if( ! stdMaster.isValid()){
            Ext.Msg.alert('Status', 'Invalid data.');
            return;
        }
        
        var student = Ext.create('School.model.Student'), data,
        url = '/ExtJS4Training/DemoService.svc/createstudent/';
        
        student.set(stdMaster.getValues());
        data = student.getData();
        
        Ext.Ajax.request({
            url : url,
            method : 'POST',
            jsonData : data,
            headers : 
            {
                'Content-Type' : 'application/json'
            },
            success : function(response){
                // process server response here
                //re-load student data with id to set dirty = false, if trackResetOnLoad is true
                var student = Ext.create('School.model.Student');
                var resp = Ext.decode(response.responseText);
                
                if(resp.success){
                    // addstudent returns student model with Id so we can re-load model into form so form will have isDirty false
                    student.set(resp.data[0]);
                    stdMaster.loadRecord(student);
                }
                else{
                    
                    Ext.Msg.alert('Status', resp.message);
                }
                
                Ext.Msg.alert('Status', 'Saved successfully.');
            },
            failure : function(response){
                Ext.Msg.alert('Status', 'Save Failed.');
                
            }
        });
    },
    onUpdateClick : function(){
        var stdMaster = this.getStudentMasterForm();
        
        if( ! stdMaster.isDirty()){
            Ext.Msg.alert('Status', 'No pending changes to save.');
            return;
        }
        else if( ! stdMaster.isValid()){
            Ext.Msg.alert('Status', 'Invalid data.');
            return;
        }
        
        var student = Ext.create('School.model.Student'), data,
        url = '/ExtJS4Training/DemoService.svc/updatestudent/';
        
        student.set(stdMaster.getValues());
        data = student.getData();
        
        Ext.Ajax.request({
            url : url,
            method : 'POST',
            //rawData: Ext.JSON.encode(data),
            jsonData : data,
            headers : 
            {
                'Content-Type' : 'application/json'
            },
            success : function(response){
                // process server response here
                //re-load student data with id to set dirty = false, if trackResetOnLoad is true
                var student = Ext.create('School.model.Student');
                var resp = Ext.decode(response.responseText);
                
                if(resp.success){
                    // addstudent returns student model with Id so we can re-load model into form so form will have isDirty false
                    student.set(resp.data[0]);
                    stdMaster.loadRecord(student);
                    Ext.Msg.alert('Status', 'Saved successfully.');
                }
                else{
                    
                    Ext.Msg.alert('Status', resp.message);
                }
            },
            failure : function(response){
                Ext.Msg.alert('Status', 'Request Failed.');
                
            }
        });
        
    },
    
    onLoadClick : function(){
        var me = this;
        
        Ext.Ajax.request({
            url : '/ExtJS4Training/DemoService.svc/readstudent/',
            method : 'GET',
            timeout : 60000,
            params : 
            {
                id : 1
                // loads student whose Id is 1
            },
            headers : 
            {
                'Content-Type' : 'application/json'
            },
            success : function(response){
                // process server response 
                var stdMaster = me.getStudentMasterForm(), resp = Ext.decode(response.responseText);
                
                if(resp.success){
                    var student = Ext.create('School.model.Student');
                    student.set(resp.data[0]);
                    stdMaster.loadRecord(student);
                    Ext.Msg.alert('Status', 'Records loaded successfully.');
                }
                else{
                    
                    Ext.Msg.alert('Status', resp.message);
                }
                
            },
            failure : function(response){
                Ext.Msg.alert('Status', 'Request Failed.');
                
            }
        });
        
    },
    
    onDeleteClick : function(){
        var me = this, stdMaster = me.getStudentMasterForm();
        
        if( ! stdMaster.getValues(false, false, false, true).Id){
            Ext.Msg.alert('Status', 'Invalid or No data to delete.');
            return;
        }
        
        var student = Ext.create('School.model.Student'), data;
        
        student.set(stdMaster.getValues());
        data = student.getData();
        
        Ext.Msg.show({
            title : 'Delete',
            msg : 'Do you want to delete this record? ',
            width : 300,
            closable : false,
            buttons : Ext.Msg.YESNO,
            icon : Ext.Msg.QUESTION,
            fn : function(buttonValue, inputText, showConfig){
                if(buttonValue === 'yes'){
                    
                    Ext.Ajax.request({
                        url : '/ExtJS4Training/DemoService.svc/deletestudent/',
                        method : 'POST',
                        jsonData : data,
                        headers : 
                        {
                            'Content-Type' : 'application/json'
                        },
                        success : function(response){
                            // process server response 
                            var stdMaster = me.getStudentMasterForm(), resp = Ext.decode(response.responseText);
                            
                            if(resp.success){
                                Ext.Msg.alert('Status', 'Deleted successfully.');
                                stdMaster.clearForm();
                            }
                            else
                                Ext.Msg.alert('Status', 'Could not delete the record. Try again.');
                            
                        },
                        failure : function(response){
                            Ext.Msg.alert('Status', 'Request Failed.');
                            
                        }
                    });
                }
            }
            
        });
        
    },
    
    onResetClick : function(){
        this.getStudentMasterForm().getForm().reset();
    },
    
    onClearClick : function(){
        this.getStudentMasterForm().clearForm();
    }
});