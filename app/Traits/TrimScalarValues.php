<?php
namespace App\Traits;

trait TrimScalarValues
{
    public function setAttribute($key, $value)
    {
        if (is_scalar($value)) {
            $value = $this->emptyStringToNull(trim($value));
        }

        return parent::setAttribute($key, $value);
    }


    /**
     * return null value if the string is empty otherwise it returns what every the value is
     *
    */
    private function emptyStringToNull($string)
    {
        //trim every value
        $string = trim($string);

        if ($string === ''){
           return null;
        }

        return $string;
    }
}