<?php

    namespace Sfavorite\Musketeers;

    class Musketeers {


        public function saySomething($number = 1) {

            /*
            $output_text = '';
            for ($i = 1; $i <= $number; $i++)
            {
                $output_text = '</p>' . $output_text . $this->paragraphs() . '</p>';

            }
            return $output_text;
            */
            return $this->paragraphs();
        }

        private function paragraphs()
        {
            $paragraphs = array();
            //$path = dirname(dirname(__FILE__)) . '/src/';
            $path = dirname(__DIR__) . '/src/';
            $filename = 'musketeers.txt';
            $fp = @fopen($path . $filename, 'r');

            if ($fp) {
                $paragraphs = explode("\n\n", fread($fp, filesize($path . $filename)));
            } else {
                echo 'Error';
            }
            /*
            return 'On the first Monday of the month of April, 1625, the market town of
                Meung, in which the author of ROMANCE OF THE ROSE was born, appeared to
                be in as perfect a state of revolution as if the Huguenots had just made
                a second La Rochelle of it. Many citizens, seeing the women flying
                toward the High Street, leaving their children crying at the open doors,
                hastened to don the cuirass, and supporting their somewhat uncertain
                courage with a musket or a partisan, directed their steps toward the
                hostelry of the Jolly Miller, before which was gathered, increasing
                every minute, a compact group, vociferous and full of curiosity.';
            */
            return $paragraphs;
        }

        public static function showImage()
        {
            return '<img src="https://unsplash.it/200/300/?random">';
        }

        # add dimensions after the URL (800x600)
        # https://source.unsplash.com/category/nature
        # https://source.unsplash.com/random


    }
