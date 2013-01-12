<?php
class Lookup
{
    const APPLICATION_NAME = 'My Product Lookup';
    const GOOGLE_KEY       = 'AIzaSyAEfory5-Z0ru1YC0hIsmUi9ZNKaQcWPG8';

    public static function Google($needle, $country = 'DE', $thumbsnails = '150:150')
    {
        require_once 'vendor/google-api/src/Google_Client.php';
        require_once 'vendor/google-api/src/contrib/Google_ShoppingService.php';

        $client = new Google_Client();
        $client->setApplicationName(self::APPLICATION_NAME);
        $client->setDeveloperKey(self::GOOGLE_KEY);

        $service = new Google_ShoppingService($client);
        return $service->products->listProducts('public', array(
          'q'          => $needle,
          'country'    => $country,
          'rankBy'     => 'relevancy',
          'thumbnails' => $thumbsnails,
          'safe'       => false,
        ));
    }
}