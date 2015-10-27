<?php

trait Export
{


    public function toArray()
    {
        return $this->fields;
    }

    public function toCsv($delimiter = ',', $enclosure = '"', $escape = "\\")
    {
        $export = $this->toArray();

        return str_getcsv($export, $delimiter = ',', $enclosure = '"', $escape = "\\");
    }

    public function toJson($flags = null)
    {
        $flags = chain($flags)->ifElse(null, JSON_PRETTY_PRINT);

        $export = $this->toArray();

        return json_decode($export, $flags);
    }

    public function toYaml()
    {
        $export = $this->toArray();
    }

    public function toSerialized()
    {
        return serialize($this->toArray());
    }

    public function toArrayCollection(array $collection)
    {
        return chain($collection)
            ->arr_collectMethod($this, 'toArray')
        ;
    }

    public function toCsvCollection(array $collection, $delimiter = ',', $enclosure = '"', $escape = "\\")
    {
        return chain($collection)
            ->arr_collectMethod($this, 'toCsv'[$delimiter, $enclosure, $escape])
        ;
    }

    public function toJsonCollection(array $collection, $flags = null)
    {
        return chain($collection)
            ->arr_collectMethod($this, 'toJson', [$flags])
        ;
    }

    public function toYamlCollection(array $collection)
    {
        $export = $this->toArrayCollection($collection);
    }

    public function toSerializedCollection(array $collection)
    {
        $export = $this->toArrayCollection($collection);

        return serialize($export);
    }
}
