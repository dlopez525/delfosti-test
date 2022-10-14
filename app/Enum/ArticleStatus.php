<?php

namespace App\Enum;

enum ArticleStatus:string
{
    case PUBLISHED = 'published';
    case DRAFT = 'draft';
}
