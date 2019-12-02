<html>
  <body>
  <h1>Star Wars API</h1>
    <div class="app-desc">This is a simple API</div>
    <div class="app-desc">Contact Info: <a href="aghoghojao@gmail.com">aghoghojao@gmail.com</a></div>
    <div class="app-desc">Version: 1.0.0</div>
    <div class="app-desc">BasePath:https://starwars-2019.herokuapp.com/api</div>

  <h3>Table of Contents </h3>
  <div class="method-summary"></div>
  <h4><a href="#Characters">Characters</a></h4>
  <ul>
   <li><a href="#getpeople"><code><span class="http-method">get</span> /characters</code></a></li>
  <li><a href="#getpeopleid"><code><span class="http-method">get</span> /characters/{characterId}</code></a></li>
  </ul>
  <h4><a href="#Comment">Comment</a></h4>
  <ul>
  <li><a href="#getcomments"><code><span class="http-method">get</span> /comments</code></a></li>
  <li><a href="#getcommentsId"><code><span class="http-method">get</span> /comments/{commentId}</code></a></li>
    
  </ul>
  <h4><a href="#Films">Films</a></h4>
  <ul>
  <li><a href="#movieMovieIdGet"><code><span class="http-method">get</span> /movie/{movieId}</code></a></li>
  <li><a href="#allmovies"><code><span class="http-method">get</span> /movie</code></a></li>
  <li><a href="#moviecharacters"><code><span class="http-method">get</span> /movie/{movieId}/characters/</code></a></li>
  <li><a href="#moviecomments"><code><span class="http-method">get</span> /movie/(movieId}/comments</code></a></li> 
  <li><a href="#createcomment"><code><span class="http-method">post</span> /movie/{movieId}/comments</code></a></li>
  </ul>

  <h1><a name="Characters">Characters</a></h1>
  <div class="method"><a name="getpeople"/>
      <div class="method-path">
      <pre class="get"><code class="huge"><span class="http-method">get</span> /people</code></pre></div>
       <div class="method-summary">Get all characters.</div>
      <h3 class="field-label">Response</h3>
      <div class="example-data-content-type">Content-Type: application/json</div>
      <pre class="example"><code>{
       "status_code": 200,
       "status_message": "Success",
        "data": {
                "type": "character",
                "id": "1",
                "attributes": {
                    "name": "Luke Skywalker",
                    "height": "172",
                    "gender": "male"
                },
                "movies": [
                            "https://starwars-2019.herokuapp.com/api/movie/2",
                            "https://starwars-2019.herokuapp.com/api/movie/6",
                            "https://starwars-2019.herokuapp.com/api/movie/3",
                            "https://starwars-2019.herokuapp.com/api/movie/1",
                            "https://starwars-2019.herokuapp.com/api/movie/7"
                         ]
            }
          }</code></pre>
    </div>
    <hr/>
  <div class="method"><a name="getpeopleid"/>
    <div class="method-path">
    <pre class="get"><code class="huge"><span class="http-method">get</span> /people/peopleId</code></pre></div>
     <div class="method-summary">Get a single character with the character id.By passing in the character id to get the details of the character.</div>

<h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
      <li>peopleId (required)</li>
    </ul>
    <h3 class="field-label">Response</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>{
     "status_code": 200,
     "status_message": "Success",
      "data": {
              "type": "character",
              "id": "1",
              "attributes": {
                  "name": "Luke Skywalker",
                  "height": "172",
                  "gender": "male"
              },
              "movies": [
                          "https://starwars-2019.herokuapp.com/api/movie/2",
                          "https://starwars-2019.herokuapp.com/api/movie/6",
                          "https://starwars-2019.herokuapp.com/api/movie/3",
                          "https://starwars-2019.herokuapp.com/api/movie/1",
                          "https://starwars-2019.herokuapp.com/api/movie/7"
                       ]
          }
        }</code></pre>
  </div>
  <hr/>
  <h1><a name="Comment">Comments</a></h1>
  <div class="method"><a name="getcomments"/>
    <div class="method-path">
    <pre class="get"><code class="huge"><span class="http-method">get</span> /comment</code></pre></div>
    <div class="method-summary">loads all comments (<span class="nickname">commentListGet</span>)</div>
    <h3 class="field-label">Response</h3>
    <ul>
          <li><code>application/json</code></li>
    </ul>
    <pre><code>
    {
        "status_code": 200,
        "status_message": "Comment Successfully Created",
        "total": 6,
        "data": [
            {
                "type": "comments",
                "id": "20",
                "attributes": {
                    "title": "This Star wars is crapula",
                    "ip_address": "::1",
                    "date_added": "2019-11-29 23:37:20"
                }
            },
            {
                "type": "comments",
                "id": "19",
                "attributes": {
                    "title": "this is test commnet",
                    "ip_address": "154.118.70.57",
                    "date_added": "2019-11-22 09:34:35"
                }
            }
        ]
    }
    </code></pre>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getcommentsId"/>
      <div class="method-path">
      <pre class="get"><code class="huge"><span class="http-method">get</span> /comment/commentId</code></pre></div>
      <div class="method-summary">Get a single comment details by passing the commentId.(<span class="nickname"></span>)</div>
      <h5 class="field-label">Parameters</h5>
       <div class="field-items">
            <div class="param">commentId (required)</div>
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; Numeric ID of the movie to get </div>
       </div> 
      <h3 class="field-label">Response</h3>
      <ul>
            <li><code>application/json</code></li>
      </ul>
      <pre><code>
      {
          "status_code": 200,
          "status_message": "Comment Successfully Created",
          "total": 1,
          "data": {
              "type": "comments",
              "id": "17",
              "attributes": {
                  "title": "this is test commnet",
                  "ip_address": "::1",
                  "date_added": "2019-11-22 08:59:02"
              },
              "relationships": {
                  "films": {
                      "data": {
                          "type": "movies",
                          "id": "1"
                      }
                  }
              },
              "included": {
                  "type": "movies",
                  "id": "1",
                  "attributes": {
                      "name": "The Phantom Menace"
                  }
              }
          }
      }
      </code></pre>
    </div> <!-- method -->
    <hr/>
  
  <h1><a name="Films">Films</a></h1>
  <div class="method"><a name="movieMovieIdGet"/>
    <div class="method-path">
    <pre class="get"><code class="huge"><span class="http-method">get</span> /movie/{movieId}</code></pre></div>
    <div class="method-summary">Gt a single movie with the movie id.By passing in the movie id to get the details of the movie</div>
    <h5 class="field-label">Parameters</h5>
    <div class="field-items">
      <div class="param">movieId (required)</div>
      <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; Numeric ID of the movie to get </div>
    </div>  <!-- field-items -->
     <h3 class="field-label">Responses</h3>
     <ul>
           <li><code>application/json</code></li>
       </ul>
  
   <pre class="example"><code>
   {
       "status_code": 200,
       "status_message": "Success",
       "data": {
           "type": "movie",
           "id": 1,
           "attributes": {
               "name": "The Phantom Menace",
               "release_date": "1999-05-19",
               "opening_crawl": "Turmoil has engulfed the\r\nGalactic Republic. The taxation\r\nof trade routes to outlying star\r\nsystems is in dispute.\r\n\r\nHoping to resolve the matter\r\nwith a blockade of deadly\r\nbattleships, the greedy Trade\r\nFederation has stopped all\r\nshipping to the small planet\r\nof Naboo.\r\n\r\nWhile the Congress of the\r\nRepublic endlessly debates\r\nthis alarming chain of events,\r\nthe Supreme Chancellor has\r\nsecretly dispatched two Jedi\r\nKnights, the guardians of\r\npeace and justice in the\r\ngalaxy, to settle the conflict....",
               "count of comments": 5
           },
           "comments": [
               "https://starwars-2019.herokuapp.com/api//comments/1",
               "https://starwars-2019.herokuapp.com/api//comments/2",
               "https://starwars-2019.herokuapp.com/api//comments/17",
               "https://starwars-2019.herokuapp.com/api//comments/18",
               "https://starwars-2019.herokuapp.com/api//comments/19"
           ],
           "characters": [
               "https://starwars-2019.herokuapp.com/api/characters/2",
               "https://starwars-2019.herokuapp.com/api/characters/3",
               "https://starwars-2019.herokuapp.com/api/characters/10",
               "https://starwars-2019.herokuapp.com/api/characters/11",
               "https://starwars-2019.herokuapp.com/api/characters/16",
               "https://starwars-2019.herokuapp.com/api/characters/20",
               "https://starwars-2019.herokuapp.com/api/characters/21",
               "https://starwars-2019.herokuapp.com/api/characters/32",
               "https://starwars-2019.herokuapp.com/api/characters/33",
               "https://starwars-2019.herokuapp.com/api/characters/34",
               "https://starwars-2019.herokuapp.com/api/characters/36",
               "https://starwars-2019.herokuapp.com/api/characters/37",
               "https://starwars-2019.herokuapp.com/api/characters/38",
               "https://starwars-2019.herokuapp.com/api/characters/39",
               "https://starwars-2019.herokuapp.com/api/characters/40",
               "https://starwars-2019.herokuapp.com/api/characters/41",
               "https://starwars-2019.herokuapp.com/api/characters/42",
               "https://starwars-2019.herokuapp.com/api/characters/43",
               "https://starwars-2019.herokuapp.com/api/characters/44",
               "https://starwars-2019.herokuapp.com/api/characters/46",
               "https://starwars-2019.herokuapp.com/api/characters/48",
               "https://starwars-2019.herokuapp.com/api/characters/49",
               "https://starwars-2019.herokuapp.com/api/characters/50",
               "https://starwars-2019.herokuapp.com/api/characters/51",
               "https://starwars-2019.herokuapp.com/api/characters/52",
               "https://starwars-2019.herokuapp.com/api/characters/53",
               "https://starwars-2019.herokuapp.com/api/characters/54",
               "https://starwars-2019.herokuapp.com/api/characters/55",
               "https://starwars-2019.herokuapp.com/api/characters/56",
               "https://starwars-2019.herokuapp.com/api/characters/57",
               "https://starwars-2019.herokuapp.com/api/characters/58",
               "https://starwars-2019.herokuapp.com/api/characters/59",
               "https://starwars-2019.herokuapp.com/api/characters/47",
               "https://starwars-2019.herokuapp.com/api/characters/35"
           ]
       }
   }
   </code></pre>
  <hr/>
  <div class="method"><a name="allmovies"/>
    <div class="method-path">
    <pre class="get"><code class="huge"><span class="http-method">get</span> /movie</code></pre></div>
    <div class="method-summary">loads all movies ordered by release date in descending order</div>

   <h3 class="field-label">Response</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>
    <pre> 
     <code>
     {
         "status_code": 200,
         "status_message": "Success",
         "total": 7,
         "data": [
             {
                 "type": "movies",
                 "id": 7,
                 "attributes": {
                     "name": "The Force Awakens",
                     "release_date": "2015-12-11",
                     "opening_crawl": "Luke Skywalker has vanished.\r\nIn his absence, the sinister\r\nFIRST ORDER has risen from\r\nthe ashes of the Empire\r\nand will not rest until\r\nSkywalker, the last Jedi,\r\nhas been destroyed.\r\n \r\nWith the support of the\r\nREPUBLIC, General Leia Organa\r\nleads a brave RESISTANCE.\r\nShe is desperate to find her\r\nbrother Luke and gain his\r\nhelp in restoring peace and\r\njustice to the galaxy.\r\n \r\nLeia has sent her most daring\r\npilot on a secret mission\r\nto Jakku, where an old ally\r\nhas discovered a clue to\r\nLuke's whereabouts....",
                     "count of comments": 0
                 }
             },
             {
                 "type": "movies",
                 "id": 3,
                 "attributes": {
                     "name": "Revenge of the Sith",
                     "release_date": "2005-05-19",
                     "opening_crawl": "War! The Republic is crumbling\r\nunder attacks by the ruthless\r\nSith Lord, Count Dooku.\r\nThere are heroes on both sides.\r\nEvil is everywhere.\r\n\r\nIn a stunning move, the\r\nfiendish droid leader, General\r\nGrievous, has swept into the\r\nRepublic capital and kidnapped\r\nChancellor Palpatine, leader of\r\nthe Galactic Senate.\r\n\r\nAs the Separatist Droid Army\r\nattempts to flee the besieged\r\ncapital with their valuable\r\nhostage, two Jedi Knights lead a\r\ndesperate mission to rescue the\r\ncaptive Chancellor....",
                     "count of comments": 0
                 }
             }
         ]
     }
     </code></pre>
  </div> <!-- method -->
  <hr/>
    <div class="method"><a name="moviecharacters"/>
      <div class="method-path">
      <pre class="get"><code class="huge"><span class="http-method">get</span> /movie/{movieId}/characters</code></pre></div>
      <div class="method-summary">loads the characters of a selected movie.The user can sort the data by sending a sort query parameter.
      The user can also filter through the data by sending a filter query parameter</div>
      <h3 class="field-label">Parameters</h3>
      This API accepts parameters to be passed to get the data you want.
       <ul>
              <li><code>filter (female || male || unknown)</code></li>
              <li><code>sort (name || height || gender)</code></li>
       </ul>
      <h3 class="field-label">Response</h3>
      This API call produces the following media types according to the <span class="header">Accept</span> request header;
      the media type will be conveyed by the <span class="header">Content-Type</span> response header.
      <ul>
        <li><code>application/json</code></li>
      </ul>
      <pre> 
       <code>
       {
           "status_code": 200,
           "status_message": "Success",
           "data": [
               {
                   "type": "characters",
                   "id": "5",
                   "attributes": {
                       "name": "Leia Organa",
                       "height": "150",
                       "gender": "female"
                   }
               },
               {
                   "type": "characters",
                   "id": "7",
                   "attributes": {
                       "name": "Beru Whitesun lars",
                       "height": "165",
                       "gender": "female"
                   }
               }
           ],
           "metadata": {
               "count": 2,
               "height": "315cm makes 10ft and 124.02 inches"
           }
       }
       </code></pre>
    </div> <!-- method -->
    <hr/>
      <div class="method"><a name="moviecomments"/>
        <div class="method-path">
        <pre class="get"><code class="huge"><span class="http-method">get</span> /movie/{movieId}comments</code></pre></div>
        <div class="method-summary">loads all movies comments.</div>
         <h3 class="field-label">Response</h3>
        This API call produces the following media types according to the <span class="header">Accept</span> request header;
        the media type will be conveyed by the <span class="header">Content-Type</span> response header.
        <ul>
          <li><code>application/json</code></li>
        </ul>
        <pre> 
         <code>
         <h3 class="field-label">Consumes</h3>
             This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
             <ul>
               <li><code>application/json</code></li>
               <li> optional</li>
             </ul>
              <pre class="example"><code>{
               "sort" : "age"||"height"||"name",
               "order" : "asc"|| "desc",
               "filter" : "male"||"female"||"n/a"||"unknown"
             }</code></pre>
         </code></pre>
      </div> <!-- method -->
      <hr/>
         <div class="method"><a name="createcomments"/>
           <div class="method-path">
           <pre class="get"><code class="huge"><span class="http-method">post</span> /movie/{movieId}/comments</code></pre></div>
           <div class="method-summary">Create Movie Comments. The movie id is passed in the url</div>
            <h3 class="field-label">Consumes</h3>
                This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
                <ul>
                  <li><code>application/json</code></li>
                  <li> optional</li>
                </ul>
                 <pre class="example"><code>{
                  "comment" : "string && max_length=500",
                }</code></pre>
            <h3 class="field-label">Response</h3>
           This API call produces the following media types according to the <span class="header">Accept</span> request header;
           the media type will be conveyed by the <span class="header">Content-Type</span> response header.
           <ul>
             <li><code>application/json</code></li>
           </ul>
           <pre> 
            <code>
            {
                "status_code": 200,
                "status_message": "Comment Successfully Created",
            }
            </code></pre>
         </div> <!-- method -->
         <hr/>
  
<h3 class="field-label">Errors</h3>
<pre class="example"><code>
   {
       "status_code": 401,
       "status_message": "No Data Found",
   }</code></pre>
<pre class="example"><code>
   {
       "status_code": 505,
       "status_message": "Client Side Error or Validation Error",
   }</code></pre>
<pre class="example"><code>
   {
       "status_code": 400,
       "status_message": " Request could not be fulfilled as the requested resource does not exist",
   }</code></pre>
      
      
 
 

  