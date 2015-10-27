<?php

trait Import
{


    public function importCsv($csv, $delimiter = ',', $enclosure = '"', $escape = "\\")
    {
        $import = chain($csv)
            ->trim()
            ->str_getcsv($delimiter, $enclosure, $escape)
        ;

        return $this->load($import);
    }

    public function importCsvFile($path, $delimiter = ',', $enclosure = '"', $escape = "\\")
    {
        $csv = file_get_contents($path);

        return $this->importCsv($csv, $delimiter = ',', $enclosure = '"', $escape = "\\");
    }

    public function importJson($json)
    {
        $import = json_decode($json);

        return $this->load($import);
    }

    public function importJsonFile($path)
    {
        $contents = file_get_contents($path);

        return $this->importJson($json);
    }

    public function importYaml($yaml)
    {
        return yaml_parse($yaml);
    }

    public function importYamlFile($path)
    {
        $yaml = file_get_contents($path);

        return $this->importYaml($yaml);
    }

    public function importSerialized($serial)
    {
        $array = unserialize($serial);

        return $this->load($serial);
    }

    public function importSerializedFile($path)
    {
        $serial = file_get_contents($path);

        return $this->importSerialized($serial);
    }
}
