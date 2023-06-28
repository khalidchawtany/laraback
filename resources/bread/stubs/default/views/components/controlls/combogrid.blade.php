
                <label for="bread_model_variable_bread_attribute_name">{{ __('bread_attribute_label') }}</label>
                <input id="bread_model_variable_bread_attribute_name" class="easyui-combogrid" style="width:500px;" name="bread_attribute_name"
                    value="<?= $bread_model_variable->bread_attribute_name ?>"
                    data-options="
                                required: true,
                                panelWidth:900,
                                url: 'bread_model_variables/json_list',
                                idField:'id',
                                textField:'text',
                                mode:'remote',
                                method: 'get',
                                fitColumns:true,
                                selectOnNavigation: false,
                                columns:[[
                                    {field:'id', title:'Id', width:15, align:'left'},
                                    {field:'name', title:'Name', width:15, align:'left'},
                                ]],
                                ">
