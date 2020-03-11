<?php

namespace App\Service;

use App\Entity\User;
use App\Form\Type\TableSettingsType;
use Doctrine\ORM\EntityManagerInterface;

class TableSettings
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getByTableCode(array $settings, string $tableCode)
    {
        $hideColumns = isset($settings[$tableCode]['hide']) ? $settings[$tableCode]['hide'] : [];
        $limit = isset($settings[$tableCode]['limit']) ? intval($settings[$tableCode]['limit']) : 10;

        return ['hide' => $hideColumns, 'limit' => $limit];
    }

    public function save(User $user, TableSettingsType $tableSettingsType)
    {
        $settings = $user->getSettings();
        $hideColumns = $tableSettingsType->getHideColumns();
        $limit = $tableSettingsType->getLimit();
        $settings[$tableSettingsType->getTableCode()]['hide'] = $hideColumns;
        $settings[$tableSettingsType->getTableCode()]['limit'] = $limit;
        if (empty($hideColumns) && (10 === intval($limit))) {
            unset($settings[$tableSettingsType->getTableCode()]);
        }
        $user->setSettings($settings);
        $this->em->persist($user);
        $this->em->flush();
    }
}
