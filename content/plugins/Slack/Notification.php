<?php

namespace App\Plugin\Slack;

class Notification {

    /**
     * Slack token.
     *
     * @var string
     */
    protected $token;

    /**
     * Slack Base API url.
     *
     * @var string
     */
    protected $baseUrl = "https://slack.com/api";

    /**
     * Class constructor.
     *
     * @param string $token
     */
    public function __construct($token = null)
    {
        $this->token = $token ? $token : env('SLACK_TOKEN');
    }

    /**
     * Post a chat message to slack
     *
     * @param  string $message
     * @param  array  $options
     * @return array
     */
    public function postChatMessage($message, array $options = [])
    {
        $url = $this->baseUrl."/chat.postMessage?";

        $query = http_build_query($options + [
            'link_names' => false,
            'text'       => $message,
            'username'   => 'Watchdog',
            'channel'    => '#general',
            'token'      => $this->token,
        ]);

        $response = json_decode(file_get_contents($url.$query));

        $wasSuccessful = ($response && isset($response->ok) && $response->ok);

        return [
            'status' => ($wasSuccessful ? 'success' : 'error'),
            'data'   => $response
        ];
    }
}