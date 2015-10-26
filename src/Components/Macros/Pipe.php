<?php

class Pipe
{


    public static function parseParams($command)
    {
        if ($paramPosition = strpos($command, '(') === false) {
            return [];
        }

        // Replace command with string before "("
        $command = substr($command, 0, $paramPosition - 1);

        // Get the parameters.
        return chain($command)
            ->str_after($paramPosition)
            ->ltrim('(')
            ->rtrim(')')
            ->arr_explode(',', true)
            ->arr_each(function ($array, $key, $value, $objectCalling) {

                $param = chain($value)
                    ->trim()
                    ->convert_ifEquals('true', true)
                    ->convert_ifEquals('false', false)
                    ->convert_ifEquals('null', null)
                    ->get()
                ;

                // Do we have an array?
                // Begins with "["
                if (str($param)->begins('[') === true) {

                    $param = chain($param)
                        ->ltrim('[')
                        ->rtrim(']')
                        ->get()
                    ;

                    // Put on the "( )" so the code knows to parse it.
                    $param = Pipe::parseParams('(' . $param . ')');
                }

                return $param;
            })
            ->get()
        ;
    }

    public static function parseCommand($command)
    {
        // If we're looking up a Helper: replace ":" with "_".
        if (strpos($command, ':') !== false) {
            $command = str_replace(':', '_', $command);
        }

        $params = self::paraseParams($command);

        return [$command, $params];
    }

    public static function parse($pipeAll)
    {
        $pipes    = explode('|', $pipeAll);
        $commands = [];

        foreach ($pipes as $pipe) {

            list($command, $params) = self::parseCommand($pipe);

            $commands[$command] = $params;
        }

        return $commands;
    }
}