
            {field:'bread_attribute_name',
                title: '{{ __('bread_attribute_label') }}',
				as: 'bread_attribute_as',
				width:35,
				align:'center',
                editor: {
                    type: 'combobox',
                    options: {
                        panelHeight: 'auto',
                        hasDownArrow: true,
                        limitToList: false,
                        valueField: 'name',
                        textField: 'name',
                        method:'get',
                        mode: 'remote',
                        url:'bread_attribute_combobox_url',
                    }
                }
            },

