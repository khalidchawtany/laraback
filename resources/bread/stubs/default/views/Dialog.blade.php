@php

  $url = isset($bread_model_variable) ? 'bread_model_variables/update' : 'bread_model_variables/create';

  $model = 'model_class_variable';
  $title = isset($bread_model_variable) ? 'Update bread_model_class' : 'New bread_model_class';
  $dialogWidth = 1000;
  $dialogHeight = 700;


  if (!isset($bread_model_variable) || $bread_model_variable == null) {
      $bread_model_variable = (object) [
          'id' => null,
	      /* bread_dialog_fields */

          'date' => now()->format('Y-m-d'),
          'merchant_name' => null,
          'product_name' => null,
          'product_type' => null,
          'manufacture_co' => null,
          'brand' => null,

          'office_name' => null,
          'vehicle_number' => null,
          'product_weight' => null,
          'company_code' => null,

          'product_color' => null,
          'expiry_date' => null,
          'production_date' => null,
          'batch_id' => null,

          'issue' => null,
          'verdict' => null,
          'body' => '	من ……………………………………………وەك خاوەنبار  کە زانیارییەکانی بارەکەم لە خشتەی خوارەوەدا خراوەتە ڕوو (کە لە دەروازەی نێودەوڵەتی پەروێزخانەوە هاوردەم کردووە) بەڵێن دەدەم پەیوەندی بکەم بە کارگەی بەرهەمهێنەرەوە و چارەسەری کێشە و کەموکورتییەکەی بکەم بە زووترین کات,بە پێچەوانەوە پابەند دەبم بە بڕیارەکانی کۆمپانیەوە.',
      ];
  }

@endphp

@include('styles')

<div class="easyui-layout" fit="true">

  <div data-options="region:'center', border:false">

    <form id="{{ $model }}Form" method="post" novalidate>

      <input type="hidden" name="id" value="<?= $bread_model_variable->id ?>">

      <table class="w-full left medium">


        <tr>
          <td colspan="4">
            <div class=" ftitle">Info:</div>
          </td>

        </tr>
        <tr>
          <td>Date</td>
          <td>
            <input name="date" value="<?= $bread_model_variable->date ?>"
              class="easyui-datebox  w-300"
              data-options="formatter:dateFormatterServer,parser:dateParserServer">
          </td>
          <td class="pt-1 pl-2">Vehicle Number</td>
          <td class="pt-1">
            <input name="vehicle_number" class="easyui-textbox w-300"
              value="<?= $bread_model_variable->vehicle_number ?>">
          </td>

        </tr>

        <tr>
          <td class="pt-1">Office</td>
          <td class="pt-1">
            <input class="easyui-combobox w-300" name="office_name"
              value="{{ $bread_model_variable->office_name }}"
              data-options=" url: 'offices/json_list',
                                    mode: 'remote',
                                    method: 'get',
                                    valueField: 'name',
                                    textField: 'name',
                                    limitToList: true,
                                    hasDownArrow: true,
                                    panelHeight: 'auto',
                                    prompt: 'Select a office',
                                    required:true
                      ">

          </td>
          <td class="pl-2 pt-1">Merchant</td>
          <td class="pt-1">
            <input class="easyui-combobox w-300" name="merchant_name"
              value="{{ $bread_model_variable->merchant_name }}"
              data-options=" url: 'merchants/json_list',
                                    mode: 'remote',
                                    method: 'get',
                                    valueField: 'name',
                                    textField: 'name',
                                    limitToList: true,
                                    hasDownArrow: true,
                                    panelHeight: 'auto',
                                    prompt: 'Select a merchant',
                                    required:true
                      ">

          </td>

        </tr>

        <tr>
          <td class="pt-1">Manufacture Co</td>
          <td class="pt-1">
            <input name="manufacture_co" class="easyui-textbox w-300"
              value="<?= $bread_model_variable->manufacture_co ?>">
          </td>
          <td class="pl-2 pt-1">Brand</td>
          <td class="pt-1">
            <input name="brand" class="easyui-textbox w-300"
              value="<?= $bread_model_variable->brand ?>" />
          </td>
        </tr>

        <tr>
          <td class="pt-1">Company Code</td>
          <td class="pt-1">
            <input name="company_code" class="easyui-textbox w-300"
              value="<?= $bread_model_variable->company_code ?>" />
          </td>
          <td class="pl-2 pt-1">Batch #</td>
          <td class="pt-1">
            <input name="batch_id" class="easyui-textbox w-300"
              value="<?= $bread_model_variable->batch_id ?>" />
          </td>
        </tr>

        <tr>
          <td class="pt-1">Product</td>
          <td class="pt-1">
            <input name="product_name" class="easyui-textbox w-300"
              value="<?= $bread_model_variable->product_name ?>" />
          </td>
          <td class="pl-2 pt-1">Product Type</td>
          <td class="pt-1">
            <input name="product_type" class="easyui-textbox w-300"
              value="<?= $bread_model_variable->product_type ?>" />
          </td>
        </tr>

        <tr>
          <td class="pt-1">Product Color</td>
          <td class="pt-1">
            <input name="product_color" class="easyui-textbox w-300"
              value="<?= $bread_model_variable->product_color ?>">
          </td>
          <td class="pl-2 pt-1">Product Weight</td>
          <td class="pt-1">
            <input name="product_weight" class="easyui-textbox w-300"
              value="<?= $bread_model_variable->product_weight ?>">
          </td>
        </tr>


        <tr>
          <td class="pt-1">Production Date</td>
          <td class="pt-1">
            <input name="production_date" class="easyui-datebox w-300"
              value="<?= $bread_model_variable->production_date ?>"
              data-options="formatter:dateFormatterServer,parser:dateParserServer">
          </td>
          <td class="pl-2 pt-1">Expiry Date</td>
          <td class="pt-1">
            <input name="expiry_date" class="easyui-datebox w-300"
              value="<?= $bread_model_variable->expiry_date ?>"
              data-options="formatter:dateFormatterServer,parser:dateParserServer">
          </td>
        </tr>


        <tr>
          <td>Issue</td>
          <td colspan="3">
            <div class="mt-1">
              <input name="issue" value="<?= $bread_model_variable->issue ?>" class="easyui-textbox"
                multiline="true" style="width:96%; height:81px; ">
            </div>
          </td>
        </tr>


        <tr>
          <td>Body</td>
          <td colspan="3">
            <div class="mt-1">
              <input name="body" value="<?= $bread_model_variable->body ?>" class="easyui-textbox"
                multiline="true" style="width:96%; height:81px; ">
            </div>
          </td>
        </tr>

        <tr>
          <td>Verdict</td>
          <td colspan="3">
            <div class="mt-1">
              <input name="verdict" value="<?= $bread_model_variable->verdict ?>" class="easyui-textbox"
                multiline="true" style="width:96%; height:81px; ">
            </div>
          </td>
        </tr>

      </table>
    </form>
  </div>

  <div class="panel-buttons" data-options="region:'south', height:'auto'">

    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok"
      onclick="savemodel_class_variable()">Save</a>

    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel"
      onclick="$('#model_class_variableDialog').dialog('close');$('#model_class_variableDatagrid').edatagrid('reload');"
      style="width:90px">Cancel</a>

  </div>

</div>

<script type="text/javascript">
  $(function() {
    $('#model_class_variableDialog')
      .dialog({
        width: <?= $dialogWidth ?>,
        height: <?= $dialogHeight ?>
      })
      .dialog('center')
      .dialog('setTitle', '{{ $title }}')
      .dialog('open');

    // For some reason this form gets posted without my code!
    $('#{{ $model }}Form').form({
      onSubmit: function() {
        return false;
      }
    });
  });

  function savemodel_class_variable() {

    $('#{{ $model }}Form').form('submit', {

      url: '<?= $url ?>',

      onSubmit: function(param) {
        param._token = window.CSRF_TOKEN;

        if ($(this).form('validate')) {
          return true;
        }

        return false;
      },

      success: function(result) {

        var result = eval('(' + result + ')');

        if (result.isError) {
          $.messager.show({
            title: 'Error',
            msg: result.msg
          });
        } else {
          $('#model_class_variableDialog').dialog('close');
          $('#model_class_variableDatagrid').edatagrid('reload');
          $.messager.show({
            title: 'Success',
            msg: 'Operation performed successfully!'
          });
        }
      }
    });

  }
</script>
