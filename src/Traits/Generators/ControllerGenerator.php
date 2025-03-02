<?php

namespace Kjdion84\Laraback\Traits\Generators;

trait ControllerGenerator
{
    public function generateController()
    {
        if ($this->userWants('controller')) {
            $this->mkDirFor('controller');
            $this->createFile(
                'controller/controller.php',
                base_path(
                    $this->options['paths']['controller']
                ).'/'.$this->replace['model']['bread_controller_class'].'.php'
            );
        }

    }
}
