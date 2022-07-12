<?php

namespace App\Services;

use MailchimpMarketing\ApiClient;

class Newsletter
{
    public function subscribe(string $email, $list = null)
    {
        $list ??= config('services.mailchimp.list.subscribers'); // the null safe assignment operator
        // $mailchimp = new ApiClient();

        // $mailchimp->setConfig([
        //     'apiKey' => config('services.mailchimp.key'),
        //     'server' => 'us14'
        // ]);
        // $response = $mailchimp->lists->addListMember($list, [
        //     //'email_address' => 'laviniaanamariatinca@gmail.com', //this is hardcoding, just to check the functionality
        //     'email_address' => request('email'),
        //     'status' => 'subscribed'
        // ]);
        return $this->client()->lists->addListMember($list, [
            //'email_address' => 'laviniaanamariatinca@gmail.com', //this is hardcoding, just to check the functionality
            'email_address' => request('email'),
            'status' => 'subscribed'
        ]);
    }

    protected function client()
    {
        $mailchimp = new ApiClient();
        return $mailchimp->setConfig([
            'apiKey' => config('services.mailchimp.key'),
            'server' => 'us14'
        ]);
    }
}
