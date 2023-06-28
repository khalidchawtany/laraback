<div id="bread_model_classDatagridContainer" style="width:100%;height:100%;">
    <table id="bread_model_classDatagrid"></table>

    <div id="bread_model_classDatagridToolbar" style="padding:5px;text-align:center;">
        @can('create_bread_model_variable')
        <!-- bread_model_dialog_show_button -->
        <a href="#" class="easyui-linkbutton" iconCls="icon-add"  onclick="javascript:$('#bread_model_classDatagrid').edatagrid('addRow')">New</a>
        @endcan
        <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="javascript:$('#bread_model_classDatagrid').edatagrid('reload')">Reload</a>
        @can('destroy_bread_model_variable')
            <a href="#" class="easyui-linkbutton" iconCls="icon-remove"  onclick="removebread_model_class()">Remove</a>
        @endcan
    </div>

</div>


<!-- model_dialog_placeholder -->

<style media="screen">

    #bread_model_classDatagridContainer .datagrid-view .datagrid-body{
        background: url('/img/datagrid/bread_model_variable.png') no-repeat center;
    }

</style>


<script type="text/javascript">

  $(function(){
    $('#bread_model_classDatagrid').edatagrid({
      idField:'id',
      title: 'bread_model_strings',
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

            {
                field: 'id',
                title: 'Id',
                width: 50,
            },

          /* bread_datagrid_column */

          {field:'action',title:'Action',width:100,align:'center',
              formatter:function(value,row,index){
                  var s = "";
                  if (row.editing){
                      s += '<button onclick="saveRow(\'bread_model_classDatagrid\', ' + index +')">Save</button> ';
                      s += '<button onclick="cancelRow(\'bread_model_classDatagrid\', ' + index +')">Cancel</button>';
                  } else {
                      s += '<button onclick="editRow(\'bread_model_classDatagrid\', ' + index + ')">Edit</button> ';
                      s += '<button onclick="deleteRow(\'bread_model_classDatagrid\', ' + index + ')">Delete</button> ';
                  }
                  return s;
              }
          }

        ]],

        /* bread_model_dialog_on_dblclick_datagrid*/

    });
  });

  $('#bread_model_classDatagrid').edatagrid('enableFilter', [
      {
          field: 'action',
          type: 'label'
      }
  ]);

  <!-- bread_model_dialog_show_js_function -->



</script>
