<?php

    namespace Sfavorite\Musketeers;
    use GuzzleHttp\Exception\RequestException;
    use GuzzleHttp\Client;

    class Musketeers {

        private $userInfo;
        private $countryCodes;

        function __construct() {

            $this->userInfo = NULL;
            $this->countryCodes = require(__DIR__ . '/countries.php');
        }



        public static function showImage()
        {
            return '<img src="https://unsplash.it/200/300/?random">';
        }

        # add dimensions after the URL (800x600)
        # https://source.unsplash.com/category/nature
        # https://source.unsplash.com/random

        public function saySomething($number = 1) {


            return $this->paragraphs($number);
        }

        private function paragraphs($number)
        {
            $paragraphs = array();
            $output_array = array();
            $path = dirname(__DIR__) . '/src/';
            $filename = 'musketeers.txt';
            $fp = @fopen($path . $filename, 'r');

            if ($fp) {
                $paragraphs = explode("\n\n", fread($fp, filesize($path . $filename)));
            } else {
                echo 'Error';
            }
            # We may not have as much text as the user wants so
            # we need to repeat text.
            if (count($paragraphs) < $number) {
                $repeat = $number / count($paragraphs);
                $size = count($paragraphs);
            }
            else {
                $repeat = 0;
                $size = $number;
            }

            # Now we have our sizing get the text in an array.
            for ($count = 0; $count <= $repeat; $count++) {
                $output_array = array_merge($output_array, array_slice($paragraphs, 0, $size));
            }

            return $output_array;
        }

        public function Title() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['user']['name']['title'];
        }

        public function FirstName() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['user']['name']['first'];
        }

        public function LastName() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['user']['name']['last'];
        }

        public function Password() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['user']['password'];
        }

        public function Email() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['user']['email'];
        }

        public function Gender() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['user']['gender'];
        }

        public function DOB() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['dob'];
        }

        public function Street() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['user']['location']['street'];
        }

        public function City() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['user']['location']['city'];
        }

        public function State() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['user']['location']['state'];
        }

        public function Zip() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['user']['location']['zip'];
        }

        public function Phone() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['user']['phone'];
        }

        public function Cell() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['user']['cell'];
        }

        public function thumbnailPicture() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['user']['picture']['thumbnail'];
        }

        public function mediumPicture() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['user']['picture']['medium'];
        }

        public function largePicture() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][0]['user']['picture']['large'];
        }

        public function Nationality() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['nationality'];
        }

        public function nationName() {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            try {
                $code = $this->userInfo['nationality'];
                return $this->countryCodes[$code]['name'];
            } catch (Exception $e) {
                echo 'An Error has accord at the network level...yeah Internet';
            }
        }
        private function getMusketeerInfo($genderMusketeer = null, $numberMusketeer=1) {

            $url = '';
            $params = array();
            $params['results'] = 1;

            $client;
            $this->client = new Client();

            if (getenv('RANDOM_API_KEY')) {
                $numberMusketeers = 1;
                $url .= 'results=' . $numberMusketeer . "&key=" . getenv('RANDOM_API_KEY');
                echo $url;
            }
            if ($genderMusketeer !== null) {
                $url .= "gender=" . $genderMusketeer;
            }
            //$response = $this->client->request('GET', 'http://api.randomuser.me/');
            try {
            //$response = $this->client->request('GET', 'https://randomuser.me/api/?gender=female&results=2&key=VDL2-2U79-LH5R-KTGV');
            $response = $this->client->request('GET', 'https://randomuser.me/api/' . $url);
            $this->userInfo = json_decode($response->getBody(), true);
            } catch (RequestException $e) {
                echo 'An Error has accord at the network level...yeah Internet';
                if ($e->hasResponse()) {
                    echo $e->getResponse();
                }
            }
            /*
            foreach ($this->userInfo['results'] as $info) {
                echo $info['user']['name']['first'];
                echo "<img src=" . $info['user']['picture']['large'] . " alt=\"User Picture\">";
            }
            */
        }

    }
