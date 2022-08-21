<?php


namespace Orizaba\LaravelComponents\Traits;


trait NavigateTraits
{
    /**
     * Returns a retroactive list of all the traits-names
     * used by the current class and all its parents.
     *
     * @return array
     */
    public function getClassUses()
    {
        $class = static::class;
        static $traits = [];

        if (empty($traits)) {
            do {
                $traits = array_merge($traits, array_keys(class_uses($class)));
            } while ($class = get_parent_class($class));
        }

        return $traits;
    }


    /**
     * @param $className
     *
     * @return bool
     */
    public function supportsTrait($className)
    {
        $traits = $this->getClassUses();

        return in_array($className, $traits);
    }
}