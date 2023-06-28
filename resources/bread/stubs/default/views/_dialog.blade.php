@php

    $url = isset($bread_model_variable) ? 'bread_model_variables/update' : 'bread_model_variables/create';

    $model = 'bread_model_class';

    $title = isset($bread_model_variable) ? __('Update bread_model_class') : __('New bread_model_class');

    $dialogWidth = 1000;

    $dialogHeight = 700;

    if (!isset($bread_model_variable) || $bread_model_variable == null) {
        $bread_model_variable = (object) [
            'id' => null,
            /* bread_dialog_fields */

            'date' => now()->format('Y-m-d'),
            'vehicle_number' => null,
            'merchant_name' => null,

            'office_name' => null,

            'verdict' => null,
        ];
    }

@endphp

@include('styles')

<div class="easyui-layout" fit="true">

    <div data-options="region:'center', border:false">

        <form id="{{ $model }}Form" method="post" novalidate>

            <input type="hidden" name="id" value="<?= $bread_model_variable->id ?>">

            <div
                style="padding: 20px; display:grid; grid-template-columns: 100px 700px; grid-template-rows: 30px; column-gap: 10px; row-gap: 10px;">

                <label for="product_category_name">{{ __('Name') }}</label>
                <input id="product_category_name" name="name" value="<?= $bread_model_variable->name ?>"
                    class="easyui-textbox w-500" data-options="required: true,">

                <label for="product_category_note">{{ __('Note') }}</label>
                <input name="note" value="<?= $bread_model_variable->note ?>" class="easyui-textbox" multiline="true"
                    style="width:500px; height:81px; ">

            </div>


            <table class="w-full left medium">

                <tr>
                    <td colspan="4">
                        <div class=" ftitle">Info:</div>
                    </td>

                </tr>

                <tr>
                    <td>Date</td>
                    <td>
                        <input name="date" value="<?= $bread_model_variable->date ?>" class="easyui-datebox  w-300"
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

                    <td class="pl-2 pt-1"></td>
                    <td class="pt-1"></td>

                </tr>

                <tr>
                    <td>Note</td>
                    <td colspan="3">
                        <div class="mt-1">
                            <input name="note" value="<?= $bread_model_variable->note ?>"
                                class="easyui-textbox" multiline="true" style="width:96%; height:81px; ">
                        </div>
                    </td>
                </tr>

            </table>
        </form>
    </div>

    <div class="panel-buttons" data-options="region:'south', height:'auto'">

        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok"
            onclick="savebread_model_class()">{{ __('Save') }}</a>

        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel"
            onclick="$('#bread_model_classDialog').dialog('close');$('#bread_model_classDatagrid').edatagrid('reload');"
            style="width:90px">{{ __('Cancel') }}</a>

    </div>

</div>

<script type="text/javascript">
    $(function() {
        $('#bread_model_classDialog')
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

    function savebread_model_class() {

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
                        title: '{{ __('Error') }}',
                        msg: result.msg
                    });
                } else {
                    $('#bread_model_classDialog').dialog('close');
                    $('#bread_model_classDatagrid').edatagrid('reload');
                    $.messager.show({
                        title: '{{ __('Success') }}',
                        msg: '{{ __('Operation performed successfully!') }}'
                    });
                }
            }
        });

    }
</script>
