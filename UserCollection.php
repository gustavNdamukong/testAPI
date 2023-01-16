<?php

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, User>
 */
class UserCollection implements IteratorAggregate
{
    /** @var User[] */
    private array $list = [];

    public function add(User $user): void
    {
        $this->list[] = $user;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->list);
    }

    public function getCount()
    {
        if ($this->list)
        {
            return count($this->list);
        }
        else
        {
            return 0;
        }
    }
}