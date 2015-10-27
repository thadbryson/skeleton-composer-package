<?php

trait Reset
{


    public function reset()
    {
        $this->fields = $this->defaults;

        return $this;
    }
}
