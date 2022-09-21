<?php

namespace src\oop\app\src\Transporters;

class CurlStrategy implements TransportInterface
{

    public function getContent(string $url): string
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $content = curl_exec($curl);
        curl_close($curl);
        return $content;
    }

}
