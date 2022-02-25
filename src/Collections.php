<?php

declare(strict_types=1);


namespace zhangrui\clickhouse;


class Collections implements \ArrayAccess, \JsonSerializable, \Countable
{
    /** @var Collection[] */
    protected $container = [];

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($this->container[$offset])) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $toArray = [];
        foreach ($this->container as $key => $collection) {
            $toArray[$key] = get_object_vars($collection);
        }
        return $toArray;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->container);
    }
}
