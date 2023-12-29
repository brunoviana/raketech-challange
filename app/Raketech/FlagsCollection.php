<?php

namespace App\Raketech;

class FlagsCollection implements FlagsCollectionInterface
{
    protected array $flag = [];

    private $index = 0;

    public function addFlag(FlagInterface $flag): void
    {
        $this->flag[] = $flag;
    }

    public function current()
    {
        return $this->flag[$this->index];
    }

    public function next()
    {
        $this->index ++;
    }

    public function key()
    {
        return $this->index;
    }

    public function valid()
    {
        return isset($this->flag[$this->key()]);
    }

    public function rewind()
    {
        $this->index = 0;
    }

    public function reverse()
    {
        $this->flag = array_reverse($this->flag);
        $this->rewind();
    }
}
