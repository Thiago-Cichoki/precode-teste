<?php


namespace util\interfaces;

interface ICrud
{
    function create($params);
    function read($id);
    function readAll();
    function update($params);
    function delete($id);
}