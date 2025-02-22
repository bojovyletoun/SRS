<?php

declare(strict_types=1);

namespace App\Model\Settings\Queries\Handlers;

use App\Model\Settings\Exceptions\SettingsItemNotFoundException;
use App\Model\Settings\Queries\SettingDateTimeValueQuery;
use App\Model\Settings\Repositories\SettingsRepository;
use DateTimeImmutable;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SettingDateTimeValueQueryHandler implements MessageHandlerInterface
{
    public function __construct(private SettingsRepository $settingsRepository)
    {
    }

    /**
     * @throws SettingsItemNotFoundException
     */
    public function __invoke(SettingDateTimeValueQuery $query): ?DateTimeImmutable
    {
        $setting = $this->settingsRepository->findByItem($query->getItem());
        $value   = $setting->getValue();
        if ($value === null) {
            return null;
        }

        return new DateTimeImmutable($value);
    }
}
