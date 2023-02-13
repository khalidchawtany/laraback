        function getSelectedbread_model_class(column) {
            var row = $('#bread_model_classDatagrid').datagrid('getSelected');

            if (!row) {
                $.messager.show({
                    title: 'Error',
                    msg: 'Please select a bread_model_variable'
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
            $('#bread_model_classDialog').dialog('setTitle', 'New bread_model_class')
                .dialog('refresh', 'bread_model_variables/dialog' + params);
        }
