<?php namespace MoodleSDK\Api;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Util\Reflection;

abstract class ModelBase
{

    public function __construct()
    {
    }

    public function apiCall(ApiContext $apiContext, $method = '', $payload = null)
    {
        $call = $apiContext->newCall($method, $payload);
        return $call->execute();
    }

    public function fromArray($data)
    {
        foreach ($data as $k => $v) {
            if (!method_exists($this, 'fromArrayExcludedProperties') || !in_array($k, $this->fromArrayExcludedProperties())) {
                if (is_array($v)) {
                    $itemType = Reflection::getPropertyType($this, $k);
                    $items = [];

                    foreach ($v as $v_i) {
                        if ($itemType->isScalar()) {
                            $items[] = $v_i;
                        } else {
                            $item = $itemType->newInstance();
                            $item->fromArray($v_i);
                            $items[] = $item;
                        }
                    }

                    $method = Reflection::getPropertySetter($this, $k);
                    $this->{$method}($items);
                } else {
                    $method = Reflection::getPropertySetter($this, $k);
                    if ($method) {
                        $this->{$method}($v);
                    }
                }
            }
        }
    }

    public function fromJSON($data)
    {
        $this->fromArray(json_decode($data));
    }

    public function fromObject($object)
    {
        $this->fromArray((array)$object);
    }

    /**
     * @param array $additionalToArrayExcludedProperties
     * @return array
     */
    public function toArray($additionalToArrayExcludedProperties = [])
    {
        $arr = [];

        Reflection::forEachGetter($this, function ($method) use (&$arr, $additionalToArrayExcludedProperties) {
            $k = strtolower(substr($method, 3));

            if (!method_exists($this, 'toArrayExcludedProperties') || !in_array($k, $this->toArrayExcludedProperties($additionalToArrayExcludedProperties))) {
                $v = $this->{$method}();

                if (!is_null($v)) {
                    $arr[$k] = $this->valueToArray($v);
                }
            }
        });

        return $arr;
    }

    private function valueToArray($value)
    {
        if (is_array($value)) {
            $arr = [];
            foreach ($value as $k => $v) {
                $arr[$k] = $this->valueToArray($v);
            }
            return $arr;
        }
        if ($value instanceof ModelBase) {
            return $value->toArray();
        }
        if ($value instanceof \DateTime) {
            return $value->getTimestamp();
        }
        else {
            return $value;
        }
        return null;
    }

    public function toJSON()
    {
        return json_encode($this->toArray());
    }

    // Static methods

    public static function instance()
    {
        $c = get_called_class();
        return new $c();
    }
}
