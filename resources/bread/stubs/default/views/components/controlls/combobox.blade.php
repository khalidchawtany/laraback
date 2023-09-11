
                <label for="bread_model_variable_bread_attribute_name">{{ __('bread_attribute_label') }}</label>
                <input class="easyui-combobox w-500" name="bread_attribute_name"
                    value="{{ $bread_model_variable->bread_attribute_name }}"
                    data-options="url: 'bread_model_variables/json_list',
                            mode: 'remote',
                            method: 'get',
                            valueField: 'name',
                            textField: 'name',
                            limitToList: true,
                            hasDownArrow: true,
                            panelHeight: 'auto',
                            prompt: '{{ __('Select a bread_model_string') }}',
                            required:true
                ">

