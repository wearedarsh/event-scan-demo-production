<?php

namespace App\Services\EmailMarketing;

interface EmailMarketingService
{
    public function addToList(array $data, string $listId): string;

    public function removeFromList(string $subscriber_id): bool;

    public function updateSubscriber(string $subscriber_id, array $data): bool;

    public function fetchFolders(): array|string;

    public function createMailingListInFolder(string $folder_id, string $list_name): ?string;

}

?>
