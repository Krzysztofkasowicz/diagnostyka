<?php

namespace App\Enums;

enum CacheKeyEnum: string
{
    case CATEGORIES = 'categories_list';
    case CATEGORY_ROW = "category_%d";
}
