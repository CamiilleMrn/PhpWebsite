# PhpWebsite

Php website managing a team of volleyball player, allowing the coach to constitute his teams 
for various match based on multiple criteria such as evalutation performance, favorite position, 
ratio of Win/Defeat ...


## Goals

> Player photo upload

To upload the player's photo you must follow the following instructions:

- create a folder, for example "project-photos" outside the www folder (see the course's security concepts);

- add write permission to this new folder for others;

- upload your photos in this new folder.

The photos downloaded in this way belong to the user www-data, the one used to run apache.


> Player and match management

Create the pages necessary for displaying, adding, modifying, and deleting players and matches.

> Entering game sheets

Create a page allowing you to make a selection among the active players and to define for each player chosen whether he will be a starter or a substitute. If the minimum number of players is not reached, the selection cannot be validated. The selection interface should display player information: photo, height, weight, preferred position, comments and evaluations of the coach.

Adapt the display of matches to allow viewing and modifying the selection.

> Statistics

If not already done, modify the edit page of a match to allow the entry of the result as well as the evaluations of the coach.

Then create a page displaying the following statistics:

- The total number and percentage of matches won, lost, or drawn.
- A table with for each player: his current status, his preferred position, the total number of selections as a starter, the total number of selections as a substitute, the average of the evaluations of the coach, and the percentage of games won when he participated.
- If possible, also add the number of consecutive selections (optional).

> Application Framework

Secure the application by creating an authentication page (using a username and password defined in advance). No other page of the application should be accessible if the user is not authenticated.
Set up a menu that will be displayed on each page to allow the user to navigate through the application. Add all the necessary links between the different pages.

>Formatting

Use style sheets (CSS) and the basics of software ergonomics to ensure that the use of the application is as pleasant and intuitive as possible.

## Website

The website is hosted and available at this location :
https://volleyballcompetition.000webhostapp.com/ProjetPhp/PhpFiles/PlayerList.php

## Credit

- [Florent Combet](https://github.com/notHaze)
- [Camille Marion](https://github.com/CamiilleMrn)