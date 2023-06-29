
        function showbread_model_classDialog(id) {
            var params = '';
            if (id) {
                params = '?id=' + id;
            }
            openDialogWithUrl('bread_model_classDialog', '<?= route('showbread_model_classDialog') ?>' + params);
        }

        function removebread_model_class() {

            removeResourceById(
                'bread_model_classDatagrid',
                'bread_model_variables/destroy',
                '<?= __('bread_model_string') ?>',
                function() {
                    $('#bread_model_classDatagrid').datagrid('reload');
                });

        }
