<?php

namespace KP\SOLID\UseCase;

interface IQueryable {

    public function query(BaseQuery $query) : BaseQueryResult;

}