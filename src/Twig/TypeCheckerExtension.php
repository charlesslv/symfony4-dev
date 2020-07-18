<?php

namespace App\Twig;

use Doctrine\ORM\PersistentCollection;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class TypeCheckerExtension
 * @package App\Twig
 */
class TypeCheckerExtension extends AbstractExtension
{
    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_class', [$this, 'getClass']),
            new TwigFunction('is_array', [$this, 'isArray']),
            new TwigFunction('is_boolean', [$this, 'isBoolean']),
            new TwigFunction('is_float', [$this, 'isFloat']),
            new TwigFunction('is_int', [$this, 'isInt']),
            new TwigFunction('is_numeric', [$this, 'isNumeric']),
            new TwigFunction('is_string', [$this, 'isString']),
            new TwigFunction('is_date_time', [$this, 'isDateTime']),
            new TwigFunction('is_date', [$this, 'isDate']),
            new TwigFunction('is_persistent_collection', [$this, 'isPersistentCollection']),
        ];
    }

    /**
     * @param $value
     * @return null|string
     */
    public function getClass($value): ?string
    {
        return get_class($value);
    }

    /**
     * @param $value
     * @return bool|null
     */
    public function isArray($value): ?bool
    {
        return is_array($value);
    }

    /**
     * @param $value
     * @return bool|null
     */
    public function isBoolean($value): ?bool
    {
        return is_bool($value);
    }

    /**
     * @param $value
     * @return bool|null
     */
    public function isFloat($value): ?bool
    {
        return is_float($value);
    }

    /**
     * @param $value
     * @return bool|null
     */
    public function isInt($value): ?bool
    {
        return is_int($value);
    }

    /**
     * @param $value
     * @return bool|null
     */
    public function isNumeric($value): ?bool
    {
        return is_numeric($value);
    }

    /**
     * @param $value
     * @return bool|null
     */
    public function isString($value): ?bool
    {
        return is_string($value);
    }

    /**
     * @param $value
     * @return bool|null
     */
    public function isDateTime($value): ?bool
    {
        if ($value instanceof \DateTime) {
            return ("00:00:00" != $value->format('H:i:s'));
        }

        return false;
    }

    /**
     * @param $value
     * @return bool|null
     */
    public function isDate($value): ?bool
    {
        if ($value instanceof \DateTime) {
            return ("00:00:00" == $value->format('H:i:s'));
        }

        return false;
    }

    /**
     * @param $value
     * @return bool|null
     */
    public function isPersistentCollection($value): ?bool
    {
        return $value instanceof PersistentCollection;
    }
}
