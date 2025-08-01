<?php

namespace App\Twig;

use App\Entity\Transaction;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TransactionStatusExtension extends AbstractExtension
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('transaction_status', [$this, 'getStatus']),
        ];
    }

    public function getStatus(int $status): string
    {
        $allStatus = Transaction::STATUS;
        $statusName = $this->translator->trans($allStatus[$status]) ?? 'None';

        $iconPath = match ($status) {
            Transaction::STATUS_NEW => '/icons/hourglass.svg',
            Transaction::STATUS_WAITING_CONFIRMATION => '/icons/status-waiting-confirmation.svg',
            Transaction::STATUS_EXPIRED => '/icons/status-expired.svg',
            Transaction::STATUS_CONFIRMED => '/icons/status-confirmed.svg',
            Transaction::STATUS_NOT_PAID => '/icons/status-not-paid.svg',
            Transaction::STATUS_CANCELLED => '/icons/status-cancelled.svg',
        };

        $icon = ' <img src="'.$iconPath.'" alt="'.$statusName.'" class="w-5 h-5 inline-block mr-1.5 relative -translate-y-0.5" />';

        return $icon.' <span class="font-medium">'.$statusName.'</span>';
    }
}
