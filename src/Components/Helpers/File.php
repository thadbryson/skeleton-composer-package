<?php

class File
{


    public function getContents($var)
    {
        $path = chain($var)->trim();

        if ($path->is_file() === false) {
            return null;
        }

        return file_get_contents($path);
    }
}
