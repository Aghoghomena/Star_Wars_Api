Star Wars API Documentation

Introduction
 This API gives you access to a list of Star Wars movies, people and comments.

Base Url
The Base URL is the root URL for all of the API, if you ever make a request and you get back a 404 NOT FOUND response then check the Base URL first.
https://starwars-2019.herokuapp.com/api

Error
Status Code	Implication
200	Request was successful and intended action was carried out.
400	Request could not be fulfilled as the requested resource does not exist.
401	Request could not be fulfilled due to an error from the API
505	A validation or client side error occurred and the request was not fulfilled.

Resources
a)	All movies:
I Endpoint: https://starwars-2019.herokuapp.com/api/movie
Ii Method: GET
Iii About: A list of all Star Wars films
Iii Response: 
{
    "status_code": 200,
    "status_message": "Success",
    "total": 7,
    "results": [
        {
            "id": 7,
            "name": "The Force Awakens",
            "release_date": "2015-12-11",
            "opening_crawl": "Luke Skywalker has vanished.\r\nIn his absence, the sinister\r\nFIRST ORDER has risen from\r\nthe ashes of the Empire\r\nand will not rest until\r\nSkywalker, the last Jedi,\r\nhas been destroyed.\r\n \r\nWith the support of the\r\nREPUBLIC, General Leia Organa\r\nleads a brave RESISTANCE.\r\nShe is desperate to find her\r\nbrother Luke and gain his\r\nhelp in restoring peace and\r\njustice to the galaxy.\r\n \r\nLeia has sent her most daring\r\npilot on a secret mission\r\nto Jakku, where an old ally\r\nhas discovered a clue to\r\nLuke's whereabouts....",
            "comments": 0
        },
    ]
}

b)	Single Movie
I Endpoint:  http://starwars-2019.herokuapp.com/api/movie/1
Ii Method: GET
Iii About: Get a single movie.
Iii Response:
{
    "status_code": 200,
    "status_message": "Success",
    "results": {
        "id": 4,
        "name": "A New Hope",
        "release_date": "1977-05-25",
        "opening_crawl": "It is a period of civil war.\r\nRebel spaceships, striking\r\nfrom a hidden base, have won\r\ntheir first victory against\r\nthe evil Galactic Empire.\r\n\r\nDuring the battle, Rebel\r\nspies managed to steal secret\r\nplans to the Empire's\r\nultimate weapon, the DEATH\r\nSTAR, an armored space\r\nstation with enough power\r\nto destroy an entire planet.\r\n\r\nPursued by the Empire's\r\nsinister agents, Princess\r\nLeia races home aboard her\r\nstarship, custodian of the\r\nstolen plans that can save her\r\npeople and restore\r\nfreedom to the galaxy....",
        "comments": 0
    }
}

c)	Characters
i.Endpoint:  http://starwars-2019.herokuapp.com/api/people
Ii Method : POST
Iii About: This api gives a list of all actors of Star Wars movie. Data can be sorted by name, gender or height in an ascending or descending order.The data can also be filtered using gender.
Iv Data: Note the parameters listed below are not required
(
[sort] => nameht||gender||height
[order] => asc||desc
[filter] => female||male||n/a||none
) 
V Response
{
    "status_code": 200,
    "status_message": "Success",
    "total": 3,
    "total_height": "360cm makes 11ft and 141.73 inches",
    "results": [
        {
            "name": "C-3PO",
            "gender": "n/a",
            "height": "167"
        },
        {
            "name": "R2-D2",
            "gender": "n/a",
            "height": "96"
        },
        {
            "name": "R5-D4",
            "gender": "n/a",
            "height": "97"
        }
    ]
}

d)	Comments
I Endpoint:  http://starwars-2019.herokuapp.com/api/comment/list
Ii Method: GET
Iii About: This list all comments in in reverse chronological order
Iv Response:
{
    "status_code": 200,
    "status_message": "Comment Successfully Created",
    "total": 5,
    "results": [
        {
            "comment": "this is test commnet",
            "ip_address": "154.118.70.57",
            "date_added": "2019-11-22 09:34:35"
        },
        {
            "comment": "this is test commnet",
            "ip_address": "::1",
            "date_added": "2019-11-22 09:02:40"
        }
    ]
}

e)	Create Comments
i.Endpoint:  http://starwars-2019.herokuapp.com/api/comment/create
Ii Method : POST
Iii About: To add comments to a movie
Iv Data: Note the parameters listed below are required
(
[comment] => string (length 1-500)
[episode_id] => integer value ranges 1-7
) 
V Response
{
    "status_code": 200,
    "status_message": "Comment Successfully Created"
}


