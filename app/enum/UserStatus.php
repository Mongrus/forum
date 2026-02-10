<?php

namespace App\enum;

enum UserStatus: string
{
    case USER = 'user';
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';

}
