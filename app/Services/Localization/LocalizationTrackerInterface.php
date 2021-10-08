<?php

namespace App\Services\Localization;

/**
 * Interface for localization services 
 * 
 * @author Joao Felizardo <joaofelizardo@ymail.com>
 */
interface LocalizationTrackerInterface
{
    /**
     * Gets all locatizations of the objects registered on the api service
     * 
     * @return array
     */
    public function all(): array;


    /**
     * Get the localization of a object with a given ID
     * 
     * @param string $deviceId the ID of ther object to track
     * 
     * @return array an array with information about the localization of the object
     */
    public function byId(string $deviceId): array;
}
