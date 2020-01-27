<?php

namespace App\Http\Controllers\Ajax\HumanResources;

use App\Helpers\DataHelper;
use App\Http\Controllers\Controller;
use App\Models\HumanResources\Client;

class ClientController extends Controller
{

    /**
     * Values of an Order.
     * @param \App\Models\HumanResources\Client $client
     * @return array
     */
    public function show(Client $client)
    {
//    	return $client;
	    $technical_limit = $client->getAvailableLimit($type = 'technical');
	    $commercial_limit = $client->getAvailableLimit($type = 'commercial');
    	return [
    		'id'                        => $client->id,
    		'url'                       => route('clients.show', $client->id),
    		'fantasy_name'              => $client->fantasy_name_text,
    		'image'                     => $client->getFileView(),
    		'short_document'            => $client->short_document,
    		'address'                   => $client->address->city_uf,
    		'email'                     => $client->email_budget,
    		'phones'                    => $client->contact->phone_formatted,
		    'technical_limit'           => $technical_limit,
    		'commercial_limit'          => $commercial_limit,
		    'technical_limit_formatted' => DataHelper::getFloat2Currency($technical_limit),
    		'commercial_limit_formatted'=> DataHelper::getFloat2Currency($commercial_limit)
	    ];
    }


}
