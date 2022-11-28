<?php

namespace KP\SOLID\UseCase;

interface ICommandable {

    public function create(BaseCommand $command) : void;

    public function update(BaseCommand $command) : void;

    public function delete(BaseCommand $command) : void;

}