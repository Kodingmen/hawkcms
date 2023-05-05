<?php
namespace System\Repository\Traits;

use Illuminate\Support\Traits\ForwardsCalls;

trait Common{
    use ForwardsCalls;

    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->getModel(), $method, $parameters);
    }

    /**
     * Handle dynamic static method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }

}
