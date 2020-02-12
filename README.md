To run this project:

clone this repo down into a folder

ensure both the class and the script are in the same folder

within the folder in the command line run "php -f deathstarPathChecker.php"

this is working on the assumtion you have php installed correctly on command line


Project rational

For this project I first started off by reading the requirements
I understood that I would need to call an api repeatedly in order
to decipher a path forward, due to this I found it best to have a service class 
that could be called to make requests to the api and format the response, as well as
Have functions for repeated logic.

I quickly discovered that I could keep going forward on the map until I hit a wall,
then i would be able to check for a path through.

Intially I tried to do this through recursion by getting the collision coordinates horizontal position then
checking If co ordinate either side of the collision had a space to go through if not check the next
position  after that and so on.

This would have worked but would only allow me to check one side of the coordinates ie to the left.
In the end I ended up checking both sides in a while loop.

If I where to repeat this I would look for a search algorithm to find the first blanks space on the next line of the map

I would also add in some tests to mock the api service class, as well as try to cut down on string parsing via sub string and explodes.
