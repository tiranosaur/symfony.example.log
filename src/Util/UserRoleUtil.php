<?php declare(strict_types=1);

namespace App\Util;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class UserRoleUtil
{
    private function __construct()
    {
    }

    public static function adminHandlig(array &$roles)
    {
        foreach ($roles as $item) {
            switch ($item) {
                case 'ROLE_SUPER_ADMIN':
                    $roles[] = 'ROLE_ADMIN';
                case 'ROLE_ADMIN':
                    $roles[] = 'ROLE_USER';
            }
        }
        return $roles;
    }
}