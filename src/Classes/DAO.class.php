<?php
require_once "autoload.php";

interface DAO{
    function get(int $id);
    function insert($obj);
    function delete($obj);
    function update($obj);
    function getAll();
}