<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;

class UnsplashComponent extends Component
{

    public function get($query = null, $page = null)
    {


        $dt = new \DateTime();

        $key = 'xwFSub0KOmC3zWGpkwss3GP5ZeS2f_Wdw84jbQu0S4A';

        $url = 'https://api.unsplash.com/';

        $client = new Client(['baseUrl' => $url]);

        $data = ['client_id' => $key, 'per_page' => 9];
        if ($query) {
            $data['query'] = $query;
        }

        if($page){
            $data['page'] = $page;
        }

        try {
            $response = $client->get('search/photos', $data)
                ->setOptions([
                    'timeout' => 3,
                ])
                ->send();
        } catch (\Throwable $th) {
            return false;
        }

        return $response->getData();
    }

}
