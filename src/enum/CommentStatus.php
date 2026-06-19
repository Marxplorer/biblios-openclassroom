<?php

namespace App\enum;

enum CommentStatus: string 
{
    case Pending = 'pending';
    case Published = 'published';
    case Moderated = 'moderated';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Enpending attente',
            self::Published => 'Publié',
            self::Moderated => 'Modéré',
        };
    }
}