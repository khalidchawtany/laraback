<?php

namespace Kjdion84\Laraback\Traits;

trait PathUtils
{
    public function getStubPath($path)
    {
        return base_path($this->options['paths']['stubs']).'/'.$path;
    }

    public function getPluginPath($path)
    {
        $pluginPath = $this->getPathFor('plugin');

        return base_path($pluginPath.$path);
    }

    public function getPluginPathFor($key)
    {
        return $this->getPluginPath($this->getPathFor($key)).'/';
    }

    public function getPathFor($key)
    {
        return $this->options['paths'][$key];
    }

    public function getNameSpaceFor($key = null)
    {
        $pluginNamespace = $this->getPathFor('namespace');

        if (empty($key)) {
            return substr($pluginNamespace, 0, -1);
        }

        $path = ucfirst($this->getPathFor($key));

        return $pluginNamespace.str_replace('/', '\\', $path);
    }

    public function getDotNameSpaceFor($key = null)
    {
        $namespace = $this->getNameSpaceFor($key);

        return strtolower(str_replace('\\', '.', $namespace));
    }
}
