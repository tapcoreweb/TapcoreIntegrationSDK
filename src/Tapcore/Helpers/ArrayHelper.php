<?php

namespace Tapcore\Helpers;

class ArrayHelper
{
    /**
     * @param array $array
     * @param string $key
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public static function value(array &$array, $key, $defaultValue = null)
    {
        return array_key_exists($key, $array) ? $array[$key] : $defaultValue;
    }

    /**
     * @param array $array
     * @param string $key
     * @param int|null $defaultValue
     *
     * @return int|null
     */
    public static function valueInt(array &$array, $key, $defaultValue = null)
    {
        return array_key_exists($key, $array)
            ? (int) $array[$key]
            : (null === $defaultValue ? null : (int) $defaultValue);
    }

    /**
     * @param array $array
     * @param string $key
     * @param string|null $defaultValue
     *
     * @return string|null
     */
    public static function valueString(array &$array, $key, $defaultValue = null)
    {
        return array_key_exists($key, $array)
            ? (string) $array[$key]
            : (null === $defaultValue ? null : (string) $defaultValue);
    }

    /**
     * @param array $array
     * @param string $key
     * @param float|null $defaultValue
     *
     * @return float|null
     */
    public static function valueFloat(array &$array, $key, $defaultValue = null)
    {
        return array_key_exists($key, $array)
            ? (float) $array[$key]
            : (null === $defaultValue ? null : (float) $defaultValue);
    }

    /**
     * @param array $array
     * @param string $key
     * @param bool|null $defaultValue
     *
     * @return bool|null
     */
    public static function valueBool(array &$array, $key, $defaultValue = null)
    {
        return array_key_exists($key, $array)
            ? (bool) $array[$key]
            : (null === $defaultValue ? null : (bool) $defaultValue);
    }

    /**
     * @param array $array
     * @param string $key
     * @param \DateTime|null $defaultValue
     *
     * @return \DateTime|null
     */
    public static function valueDate(array &$array, $key, \DateTime $defaultValue = null)
    {
        return self::valueDateTimeFromFormat($array, $key, "Y-m-d", $defaultValue);
    }

    /**
     * @param array $array
     * @param string $key
     * @param string $format
     * @param \DateTime|null $defaultValue
     *
     * @return \DateTime|null
     */
    public static function valueDateTimeFromFormat(array &$array, $key, $format, \DateTime $defaultValue = null)
    {
        return array_key_exists($key, $array)
            ? \DateTime::createFromFormat($format, $array[$key])
            : $defaultValue;
    }

    /**
     * @param array $array
     * @param string $key
     * @param \DateTime|null $defaultValue
     *
     * @return \DateTime|null
     */
    public static function valueDateTime(array &$array, $key, \DateTime $defaultValue = null)
    {
        return self::valueDateTimeFromFormat($array, $key, "Y-m-d H:i:s", $defaultValue);
    }

    /**
     * @param array $values
     *
     * @return float[]
     */
    public static function castToFloatsArray(array $values)
    {
        return array_map(function ($item) {
            return (float) $item;
        }, $values);
    }

    /**
     * @param array $values
     *
     * @return int[]
     */
    public static function castToIntegersArray(array $values)
    {
        return array_map(function ($item) {
            return (int) $item;
        }, $values);
    }

    /**
     * @param array $values
     *
     * @return string[]
     */
    public static function castToStringsArray(array $values)
    {
        return array_map(function ($item) {
            return (string) $item;
        }, $values);
    }
}
