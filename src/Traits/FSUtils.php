<?php

namespace Kjdion84\Laraback\Traits;

trait FSUtils
{
    public function mkDirFor($key)
    {
        $path = $this->getPluginPathFor($key);
        if (! file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    public function createFile($file, $target)
    {
        $file = $this->getStubPath($file);

        if (file_exists($file)) {
            file_put_contents($target, $this->replaceContent($file));
            $this->line('Created file: '.$target);
        }
    }

}
