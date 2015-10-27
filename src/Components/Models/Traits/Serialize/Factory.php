<?php



trait Factory
{


    public static function factory(array $params = [])
    {
        $product = new static();

        return $product->load($params);
    }

    public function load(array $params = [])
    {
        foreach ($params as $prop => $value) {

            $setter = chain($prop)->setter();

            $this->{$setter}($value);
        }

        return $this;
    }
}
