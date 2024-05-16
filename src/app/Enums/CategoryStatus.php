<?php

namespace App\Enums; 

enum CategoryStatus: string {
    case PUBLISHED = 'published';
    case DRAFT = 'draft';
    case CANCELLED = 'cancelled';
}

// $status = EnumTranslatorFacade::translate(CategoryStatus::class);
