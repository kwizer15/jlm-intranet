<?php

namespace App\Service\Intervention;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\ServerRequest;

interface DistanceCalculatorInterface
{
    public function betweenZipCodes(string $departureZipCode, string $destinationZipCode): int;
}

class GoogleMapDistanceCalculator implements DistanceCalculatorInterface
{
    /**
     * @var 
     */
    private $httpClient;

    /**
     * @var string
     */
    private $baseUrl;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = 'https://maps.googleapis.com/maps/api/distancematrix';
    }

    public function betweenZipCodes(string $departureZipCode, string $destinationZipCode): int
    {
        $request = new ServerRequest('GET', $this->generateUrl($departureZipCode, $destinationZipCode));
        $response = $this->httpClient->send($request);
        if (200 !== $response->getStatusCode()) {
            throw new \Exception('Googlemaps API Error.');
        }

        return (int) floor($this->getDistanceFromBody($response->getBody()) / 1000);
    }

    private function generateUrl(string $departureZipCode, string $destinationZipCode)
    {
        $httpQuery = array(
            'origins'      => $departureZipCode  . ' FRANCE',
            'destinations' => $destinationZipCode . ' FRANCE',
        );

        $httpQuery['language'] = 'fr-FR';
        $httpQuery['sensor'] = 'false';

        return sprintf('%s/%s?%s', $this->baseUrl, 'json', http_build_query($httpQuery));
    }

    private function getDistanceFromBody(\Psr\Http\Message\StreamInterface $stream): int
    {
        $xml = $stream->getContents();
        $json = json_decode($xml, true);
        if ('OK' !== $json['status']) {
            throw new \Exception('Googlemaps API Error.');
        }
        $distance = $json['rows'][0]['elements'][0]['distance']['value'] ?? null;
        if (null === $distance) {
            throw new \Exception('Can not calculate distance.');
        }

        return $json['rows'][0]['elements'][0]['distance']['value'];
    }
}

class OSRMDistanceCalculator implements DistanceCalculatorInterface
{
    /**
     * @var
     */
    private $httpClient;

    /**
     * @var string
     */
    private $geocodeBaseUrl;

    /**
     * @var string
     */
    private $distanceBaseUrl;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->geocodeBaseUrl = 'https://api-adresse.data.gouv.fr/search';
        $this->distanceBaseUrl = 'http://router.project-osrm.org/route/v1/driving';
    }

    public function betweenZipCodes(string $originZipCode, string $destinationZipCode): int
    {
        $origin = $this->getCoordinates($originZipCode);
        $destination = $this->getCoordinates($destinationZipCode);

        return (int) floor($this->getDistance($origin, $destination));
    }

    private function getCoordinates(string $zipCode)
    {
        $httpQuery = array(
            'q'      => $zipCode,
            'postcode' => $zipCode,
        );

        $url = sprintf('%s/?%s', $this->geocodeBaseUrl, http_build_query($httpQuery));

        $request = new ServerRequest('GET', $url);
        $response = $this->httpClient->send($request);
        if (200 !== $response->getStatusCode()) {
            throw new \Exception('Geocoding Error.');
        }

        $json = json_decode($response->getContents(), true);
        if (!isset($json['features'][0]['geometry']['coordinates'])) {
            throw new \Exception('Geocoding Error.');
        }
        return $json['features'][0]['geometry']['coordinates'];

    }

    private function getDistance(array $origin, array $destination): int
    {
        $stringOrigin = implode(',', $origin);
        $stringDestination = implode(',', $destination);

        $url = sprintf('%s/%s;%s', $this->distanceBaseUrl, $stringOrigin, $stringDestination);

        $request = new ServerRequest('GET', $url);
        $response = $this->httpClient->send($request);
        if (200 !== $response->getStatusCode()) {
            throw new \Exception('Distance Error.');
        }

        $json = json_decode($response->getContents(), true);
        if (!isset($json['routes'][0]['legs'][0]['distance'])) {
            throw new \Exception('Distance Error.');
        }

        return $json['routes'][0]['legs'][0]['distance'];
    }
}