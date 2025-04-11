<?php
namespace MyCache;

use Psr\SimpleCache\CacheInterface;

class ArrayCache implements CacheInterface
{
    private $cache = [];

    public function get($key, $default = null) {
        return $this->cache[$key] ?? $default;
    }

    public function set($key, $value, $ttl = null) {
        $this->cache[$key] = $value;
        return true;
    }

    public function delete($key) {
        unset($this->cache[$key]);
        return true;
    }

    public function clear() {
        $this->cache = [];
        return true;
    }

    public function getMultiple($keys, $default = null) {
        $results = [];
        foreach ($keys as $key) {
            $results[$key] = $this->get($key, $default);
        }
        return $results;
    }

    public function setMultiple($values, $ttl = null) {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }
        return true;
    }

    public function deleteMultiple($keys) {
        foreach ($keys as $key) {
            $this->delete($key);
        }
        return true;
    }

    public function has($key) {
        return isset($this->cache[$key]);
    }
}
