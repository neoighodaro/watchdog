<?php

namespace App\Plugin\Http;

use App\Service;
use App\Service\CheckerInterface;
use App\Watchdog as WatchdogModel;
use App\Service\Watchdog as WatchdogService;

class HttpChecker implements CheckerInterface {

    /**
     * Service model instance.
     *
     * @var Service
     */
    protected $service;

    /**
     * Description of the error while checking the service
     *
     * @var string
     */
    protected $description;

    /**
     * Status of the page.
     *
     * @var integer
     */
    protected $status;

    /**
     * Check the service.
     *
     * @param  Service $service
     * @return CheckerInterface
     */
    public function check(Service $service)
    {
        return $this->pingServiceUrl($service->url);
    }

    /**
     * Status of the service after checking.
     *
     * @return integer
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * Description of the error while checking the service
     *
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * Ping the service url.
     *
     * @param  string $url
     * @return integer
     */
    protected function pingServiceUrl($url)
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT      => "Watchdog/".WatchdogModel::VERSION,
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_NOBODY         => true,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        curl_exec($ch);

        $totalTime = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
        $curlError = curl_error($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        switch ($httpCode) {
            case WatchdogService::SERVICE_OK:
                $this->setStatus(WatchdogService::SERVICE_OK);
                break;
            default:
                $this->setStatus(WatchdogService::SERVICE_BAD);
                $this->setDescription($curlError);
                break;
        }

        return $this;
    }

    /**
     * Set the description.
     *
     * @param string $description
     */
    protected function setDescription($description)
    {
        if ( ! empty($description)) {
            $this->description = $description;
        }
    }

    /**
     * Set the status of the service after checking.
     *
     * @param integer $status
     */
    protected function setStatus($status)
    {
        $this->status = $status;
    }
}