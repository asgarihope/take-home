<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface NewsReaderInterface
{
public function getNews(int $page,int $perPage,):Collection;
}