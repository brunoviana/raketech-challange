<?php

namespace App\Raketech;

interface FlagsCollectionInterface extends \Iterator
{
    public function addFlag(FlagInterface $flag): void;
}
