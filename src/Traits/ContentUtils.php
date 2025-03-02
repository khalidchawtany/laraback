<?php

namespace Kjdion84\Laraback\Traits;

trait ContentUtils
{
    public function replaceContent($file)
    {
        $content = file_get_contents($file);
        $content = strtr($content, $this->replace['attributes']);
        $content = strtr($content, $this->replace['model']);

        return $content;
    }

    public function setReplaceModel()
    {
        $model = basename($this->argument('file'), '.php');
        $controller = str_plural($model);
        $string = trim(preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $0', $model));
        $modelNameSpace = $this->getNameSpaceFor(null);
        $modelDotNameSpace = $this->getDotNameSpaceFor(null);
        $tableName = $this->getPathFor('table_name');

        $this->replace['model'] = [
            'bread_model_class' => $model,
            'bread_model_variables' => str_replace(' ', '_', strtolower(str_plural($string))),
            'bread_model_variable' => str_replace(' ', '_', strtolower($string)),
            'bread_model_strings' => str_plural($string),
            'bread_model_classes' => str_plural($model),
            'bread_model_string' => $string,
            'bread_table_name' => $tableName,
            'bread_model_namespace' => $modelNameSpace,
            'bread_model_dot_namespace' => $modelDotNameSpace,
            'bread_controller_class' => $controller,
        ];

        return $this;
    }

    public function setReplaceAttributes()
    {
        $replace = [];

        foreach ($this->options['attributes'] as $name => $options) {
            // schema
            if (isset($options['schema'])) {
                $replace['/* bread_schema */'][] = $this->replaceAttribute('database/schema.php', $name, $options);
            }

            // replace factory template with the factory/faker.php for each attribute
            if (isset($options['factory'])) {
                $replace['/* bread_factory */'][] = $this->replaceAttribute('factory/faker.php', $name, $options);
            } elseif (isset($options['foreign'])) {
                $replace['/* bread_factory */'][] = $this->replaceAttribute('factory/faker_foreign.php', $name, $options);
            }

            // set foreign key
            if (! isset($options['foreign'])) {
                $options['foreign'] = '';
            } else {
                $options['foreign'] = '$table->'.$options['foreign'].';';
            }
            $replace['/* bread_foreign */'][] = $this->replaceAttribute('database/foreign.php', $name, $options);

            // rule
            foreach (['store', 'update'] as $action) {
                if (isset($options['rule_'.$action])) {
                    $replace['/* bread_rule_'.$action.' */'][] = $this->replaceAttribute('requests/rule/'.$action.'.php', $name, $options);
                }
            }

            // datatable
            if (isset($options['datatable']) && $options['datatable']) {
                $replace['<!-- bread_datatable_heading -->'][] = $this->replaceAttribute('views/datatable/heading.blade.php', $name, $options);
                $replace['/* bread_datatable_column */'][] = $this->replaceAttribute('views/datatable/column.blade.php', $name, $options);
            }

            // set field for the datagrid
            if (isset($options['datagrid_column'])) {
                $replace['/* bread_datagrid_column */'][] = $this->replaceAttribute("views/components/fields/{$options['datagrid_column']}.blade.php", $name, $options);
            }

        }

        // set buttons and dialogs for the dialog of the model
        if (isset($this->options['options']['model_dialog'])) {
            $replace['<!-- bread_model_dialog_show_button -->'][] = $this->replaceAttribute('views/components/dialog/model_dialog_show_button.blade.php', $name, $options);
            $replace['<!-- model_dialog_placeholder -->'][] = $this->replaceAttribute('views/components/dialog/model_dialog_placeholder.blade.php', $name, $options);
            $replace['<!-- bread_model_dialog_show_js_function -->'][] = $this->replaceAttribute('views/components/dialog/model_dialog_show_js_function.blade.php', $name, $options);
            $replace['/* bread_model_dialog_on_dblclick_datagrid*/'][] = $this->replaceAttribute('views/components/dialog/model_dialog_on_dblclick_datagrid.blade.php', $name, $options);
            $replace['/* bread_dialog_fields */'] = "\t\t'".implode("' => null,\n\t\t  '", array_keys($this->options['attributes']))."'=> null,";
        }

        $replace['/* bread_fillable */'] = implode('", "', array_keys($this->options['attributes']));

        foreach ($replace as $key => $values) {
            $this->replace['attributes'][$key] = trim(is_array($values) ? implode(PHP_EOL, $values) : $values);
        }

        return $this;
    }

    public function replaceAttribute($file, $name, $options)
    {
        $file = base_path($this->options['paths']['stubs']).'/'.$file;

        if (file_exists($file)) {
            $content = file_get_contents($file);

            // if the last char is a newline remove it
            if (substr($content, -1) == "\n") {
                $content = substr($content, 0, -1);
            }

            foreach ($options as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $vKey => $vValue) {
                        $content = str_replace('bread_attribute_'.$vKey, $vValue, $content);
                    }
                }
                $content = str_replace('bread_attribute_'.$key, $value, $content);
            }

            $content = str_replace('bread_attribute_class_from_foreign_key', str_replace(' ', '', ucwords(str_replace('_', ' ', substr($name, 0, -3)))), $content);
            $content = str_replace('bread_attribute_label', ucwords(str_replace('_', ' ', $name)), $content);
            $content = str_replace('bread_attribute_name', $name, $content);
        }

        return isset($content) ? $content : null;
    }
}
