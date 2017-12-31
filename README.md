# timcrawler
This is only a little script for my girlfriends brother to make experience working with GitHub.

It only calls an api from an old game.

It's not really a crawler... ;-)

## Usage
* Download repository to your local machine.
* Open your terminal and navigate to root in the downloaded project folder.
* Start the webserver (Nginx with php-fpm) with `$ docker-compose up`
* If not already done, you need to **install docker and docker-compose before**.
* Open your favorite browser.
* To fetch actual data navigate to *localhost/?action=crawl*.
* To see the list of all Items locally saved navigate to   *localhost*.
