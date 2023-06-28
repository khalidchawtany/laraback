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

                <!-- bread_dialog_controlls --!>

            </div>

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
