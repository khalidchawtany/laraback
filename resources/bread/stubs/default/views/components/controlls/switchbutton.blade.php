
                <label for="bread_model_variable_bread_attribute_name">{{ __('bread_attribute_label') }}</label>
                <input id="safe_is_default" name="is_default" <?= $bread_model_variable->bread_attribute_name ? 'checked' : '' ?>
                    class="easyui-switchbutton" label="" labelWidth="0" onText="<?= __('Yes') ?>" offText="<?= __('No') ?>" >

