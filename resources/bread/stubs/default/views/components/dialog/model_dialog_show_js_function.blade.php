        function getSelectedbread_model_class(column) {
            var row = $('#bread_model_classDatagrid').datagrid('getSelected');

            if (!row) {
                $.messager.show({
                    title: '{{ __('Error') }}',
                    msg: '{{ __('Please select a ') }}' + '{{ __('bread_model_variable') }}'
                });
                return;
            }
            if (!column) {
                return row['id'];
            }
            return row[column];
        }

        function showbread_model_classDialog(id) {
            var params = '';
            if (id) {
                params = '?id=' + id;
            }
            $('#bread_model_classDialog').dialog('setTitle', '{{ __('New bread_model_class')}}')
                .dialog('refresh', 'bread_model_variables/dialog' + params);
        }

        function removebread_model_class() {

            var id = getSelectedbread_model_class(column);

            if (!id) {
                return;
            }

            $.messager.confirm('{{ __('Confirm') }}', '{{ __('Are you sure you want to delete this') }}' + '{{ __('bread_model_string') }}?', function(r) {
                if (r) {

                    $.post('bread_model_variables/destroy', {
                        'id': row.id,
                    }, function(result) {
                        if (result.success) {

                            $('#bread_model_classDatagrid').datagrid('reload');

                        } else {
                            $.messager.show({ title: '{{ __('Error') }}', msg: result.msg});
                        }
                    }, 'json');
                }
            });
        }
