<?php

namespace App\Nova\Fields;

use Laravel\Nova\Fields\Gravatar as BaseGravatar;

class Gravatar extends BaseGravatar
{
    const MYSTY = 'mp';
    const IDENTICON = 'identicon';
    const MONSTER = 'monsterid';
    const WAVATAR = 'wavatar';
    const RETRO = 'retro';
    const ROBOHASH = 'robohash';
    const BLANK = 'blank';
    const DEFAULT = '404';

    private $default = 'wavatar';
    private $size = 200;

    public function setDefault(string $default)
    {
        $this->default = $default;
        return $this;
    }

    public function setSize(int $size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Resolve the given attribute from the given resource.
     *
     * @param mixed $resource
     * @param string $attribute
     *
     * @return mixed
     */
    protected function resolveAttribute($resource, $attribute)
    {
        $callback = function () use ($resource, $attribute) {
            return strtr('https://www.gravatar.com/avatar/{attr}?s={size}&d={default}', [
                '{attr}' => md5($resource->{$attribute}),
                '{size}' => $this->size,
                '{default}' => $this->default
            ]);
        };

        $this->preview($callback)->thumbnail($callback);
    }
}
