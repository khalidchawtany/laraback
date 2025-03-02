<?php

namespace Kjdion84\Laraback\Traits\Generators;

trait ModelGenerator
{
    public function generateModel()
    {
        if ($this->userWants('model')) {
            $this->mkDirFor('model');
            $this->createFile(
                'model.php',
                $this->getPluginPathFor('model').$this->replace['model']['bread_model_class'].'.php'
            );
        }

    }
}
