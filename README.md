skaianet-web
=====
web-based interface for listening to the music of radio.skaia.net
This is really a frontend to skaianet-engine (maybe this should be one
project not two)

Original code by George "Kitty" Burfeind; updates by Moses "Mozai" Moore


TODO
-----
* Install instructions
* why do we have so many stylesheets and javascript files?  it's 2023,
  vanillajs is more than adequate it' faster.
* redo the index.php layout so we don't need to depend on fixed-width
  for all the elements; use proper flexbox.
* rewrite anything outside of /api/ to be static HTML; we can make
  client-side javascript do the work and stop worrying about the server.
  * replace MobileDetect with javascript
  * the /api/\* requests are still served by PHP, but that could change
  * the mobile UI stuff in /m/\*  may need more work, haven't looked yet.


INSTALL
-----
Requirements: 
* nginx or equivalent 
* php ~~7.x~~ 8.x, 
* mysql/MariaDB shared with skaianet-engine
  (want to replace this with sqlite3)
* python
* icecast stream to hook into


USAGE
-----
Normal use: point a webbrowser at https://radio.skaia.net/ , turn up
the sound. Smartphones should get bounced to a stripped-down interface.

History of songs played is https://radio.skaia.net/recent.php


AUTHORS
-----
* George Burfeind (Kitty)
* Moses Moore (Mozai)

