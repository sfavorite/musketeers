<?php

    namespace Sfavorite\Musketeers;
    use GuzzleHttp\Exception\RequestException;
    use GuzzleHttp\Client;

    class Musketeers {

        public $userInfo;
        private $countryCodes;

        function __construct() {


            $this->userInfo = NULL;
            $this->countryCodes = require(__DIR__ . '/countries.php');

            // Setup a guzzle client for our http requests
            $this->client = new Client();

        }



        public function showImage()
        {
            return "https://unsplash.it/200/300/?random";
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

        public function Title($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['user']['name']['title'];
        }

        public function FirstName($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['user']['name']['first'];
        }

        public function LastName($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['user']['name']['last'];
        }

        public function Password($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['user']['password'];
        }

        public function Email($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['user']['email'];
        }

        public function Gender($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['user']['gender'];
        }

        public function DOB($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['dob'];
        }

        public function Street($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['user']['location']['street'];
        }

        public function City($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['user']['location']['city'];
        }

        public function State($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['user']['location']['state'];
        }

        public function Zip($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['user']['location']['zip'];
        }

        public function Phone($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['user']['phone'];
        }

        public function Cell($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['user']['cell'];
        }

        public function thumbnailPicture($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['user']['picture']['thumbnail'];
        }

        public function mediumPicture($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['user']['picture']['medium'];
        }

        public function largePicture($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['results'][$index]['user']['picture']['large'];
        }

        public function Nationality($index = 0) {
            if (is_null($this->userInfo)) {
                $this->getMusketeerInfo();
            }
            return $this->userInfo['nationality'];
        }

        public function nationName($index = 0) {
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

        public function getSquad($genderMusketeer = null, $numberMusketeer = 1) {

            $url = '';
            $squad = [];

            if (getenv('RANDOM_API_KEY')) {
                $url .= 'results=' . $numberMusketeer . "&key=" . getenv('RANDOM_API_KEY');
            }
            else {
                $numberMusketeers = 1;
            }
            if ($genderMusketeer !== null) {
                if ($url !== '') {
                    $url .= "&gender=" . $genderMusketeer;
                }
                else {
                    $url .= "gender=" . $genderMusketeer;
                }
            }
            $squad = $this->getMusketeerInfo($url);
            return $this->userInfo;
        }

        private function getMusketeerInfo($url = '') {

            $params = array();
            $params['results'] = 1;
            $this->userInfo = [];

            // Setup a guzzle client for our http request
            $this->client = new Client();

            try {
                if ($url !== '') {
                    $url = '?' . $url;
                }
                $response = $this->client->request('GET', 'https://randomuser.me/api/' . $url);
                $this->userInfo = json_decode($response->getBody(), true);
            } catch (\Exception $e) {
                $this->userInfo = file_get_contents(__DIR__ . '/backup_musketeers.json');
                dd($this->userInfo);
            }

        }

    }
