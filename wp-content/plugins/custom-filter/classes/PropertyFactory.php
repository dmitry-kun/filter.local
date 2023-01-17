<?php


class PropertyFactory
{
    public static function getPropertyByName($name)
    {
        return new PropertyWorker($name);
    }
}