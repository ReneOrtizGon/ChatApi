<?php

namespace App\Interfaces;

interface MessageInterface
{
    public function index();
    public function create(array $data);
    public function read($id);
    public function update(array $data, $id);
    public function delete($id);
}
