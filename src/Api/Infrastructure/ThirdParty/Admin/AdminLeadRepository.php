<?php

namespace Mi-empresa\Api\Infrastructure\ThirdParty\Admin;

use Mi-empresa\Api\Domain\DTO\LeadTeacher;
use Mi-empresa\Api\Domain\DTO\LeadUser;
use Mi-empresa\Api\Domain\Repository\LeadRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AdminLeadRepository implements LeadRepository
{
    private string $urlAdmin;

    public function __construct(private HttpClientInterface $httpClient)
    {
        $this->urlAdmin = config('admin.url');
    }

    public function sendLeadUser(LeadUser $lead): void
    {
        if (filter_var($this->urlAdmin, FILTER_VALIDATE_URL) === false) {
            return;
        }

        $response = $this->httpClient->request(
            'PUT',
            $this->urlAdmin . '/api/lead',
            [
                // these values are automatically encoded before including them in the URL
                'query' => [
                    'email' => $lead->email(),
                    'phone' => $lead->phone(),
                    'name' => $lead->name(),
                    'message' => $lead->message(),
                    'interest' => $lead->interest(),
                    'origin' => $lead->origin(),
                ]
            ]
        );
        //$content = $response->getContent();
    }

    public function sendLeadTeacher(LeadTeacher $lead): void
    {
        if (filter_var($this->urlAdmin, FILTER_VALIDATE_URL) === false) {
            return;
        }

        $response = $this->httpClient->request(
            'PUT',
            $this->urlAdmin . '/api/lead-teacher',
            [
                // these values are automatically encoded before including them in the URL
                'query' => [
                    'email' => $lead->email(),
                    'phone' => $lead->phone(),
                    'name' => $lead->name(),
                    'interest' => $lead->interest(),
                ]
            ]
        );
        //$content = $response->getContent();
    }
}
