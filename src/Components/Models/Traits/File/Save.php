<?php

trait Save
{


    public function saveCsv($path)
    {
        file_put_contents($path, $this->toCsv());

        return $this;
    }

    public function saveJson($path)
    {
        file_put_contents($path, $this->toJson());

        return $this;
    }

    public function saveYaml($path)
    {
        file_put_contents($path, $this->toYaml());

        return $this;
    }

    public function saveSerialized($path)
    {
        file_put_contents($path, $this->toSerialized());

        return $this;
    }
}
