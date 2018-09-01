<div id="bread_model_classDatagridContainer" style="width:100%;height:100%;">
    <table id="bread_model_classDatagrid"></table>

    <div id="bread_model_classDatagridToolbar" style="padding:5px;text-align:center;">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add"  onclick="javascript:$('#bread_model_classDatagrid').edatagrid('addRow')">New</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="javascript:$('#bread_model_classDatagrid').edatagrid('reload')">Reload</a>
    </div>

</div>

<style media="screen">

    #bread_model_classDatagridContainer .datagrid-view .datagrid-body{
        background: url('/img/datagrid/bread_model_variable.png') no-repeat center;
    }

</style>


<script type="text/javascript">

  $(function(){
    $('#bread_model_classDatagrid').edatagrid({
      idField:'id',
      title: 'bread_model_class',
      toolbar:'#bread_model_classDatagridToolbar',
      fit:true,
      border:false,
      fitColumns:true,
      singleSelect:true,
      method:'get',
      rownumbers:true,
      pagination:true,
      remoteFilter:true,
      filterMatchType: 'any',
      url:'bread_model_variables/list',
      saveUrl: 'bread_model_variables/create',
      updateUrl: 'bread_model_variables/update',
      destroyUrl: 'bread_model_variables/destroy',

        columns: [[
          /* bread_datagrid_column */

          {field:'action',title:'Action',width:100,align:'center',
              formatter:function(value,row,index){
                  if (row.editing){
                      var s = '<button onclick="saveRow(\'bread_model_classDatagrid\', ' + index +')">Save</button> ';
                      var c = '<button onclick="cancelRow(\'bread_model_classDatagrid\', ' + index +')">Cancel</button>';
                      return s+c;
                  } else {
                      var e = '<button onclick="editRow(\'bread_model_classDatagrid\', ' + index + ')">Edit</button> ';
                      var d = '<button onclick="deleteRow(\'bread_model_classDatagrid\', ' + index + ')">Delete</button> ';
                      return e+d;
                  }
              }
          }

        ]],

        onBeforeEdit:function(index,row){
            row.editing = true;
            $(this).edatagrid('refreshRow', index);
        },
        onAfterEdit:function(index,row){
            row.editing = false;
            $(this).edatagrid('refreshRow', index);
        },
        onCancelEdit:function(index,row){
            row.editing = false;
            $(this).edatagrid('refreshRow', index);
        },

        onDestroy: function() {
          resetPermissionCheckboxes();
        }

    });
  });

  $('#bread_model_classDatagrid').edatagrid('enableFilter', [
      {
          field: 'action',
          type: 'label'
      }
  ]);


</script>
