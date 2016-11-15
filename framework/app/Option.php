<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $fillable = ['name', 'value'];

    /**
     * Get an option from the database.
     *
     * @param  string  $option
     * @param  mixed $default
     * @return mixed
     */
    public function getOption($option, $default = false)
    {
        if ( ! $option = static::whereName(strtolower($option))->first()) {
            return $default;
        }

        return $this->isJsonEncoded($option->value)
            ? json_decode($option->value, true)
            : $option->value;
    }

    /**
     * Set an option.
     *
     * @param  string $option
     * @param  mixed  $value
     * @return mixed
     */
    public function setOption($option, $value)
    {
        $value = $this->shouldJsonEncode($value) ? json_encode($value) : $value;

        return $this->updateOrCreate(
            ['name'  => strtolower($option)],
            ['value' => $value]
        );
    }

    /**
     * Checks if the string is json encoded.
     *
     * @param  string  $string
     * @return boolean
     */
    protected function isJsonEncoded($string)
    {
        if ( ! is_string($string) OR (strpos($string, '{') !== 0 AND strpos($string, '[') !== 0)) {
            return false;
        }

        json_decode($string);

        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Check if the value should be encoded.
     *
     * @param  string $string
     * @return boolean
     */
    protected function shouldJsonEncode($string)
    {
        return ! is_string($string) && ! is_numeric($string);
    }
}
