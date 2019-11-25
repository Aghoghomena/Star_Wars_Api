<html>
  <head>
    <title>Star Wars API</title>
    <style type="text/css">
      body {
	font-family: Trebuchet MS, sans-serif;
	font-size: 15px;
	color: #444;
	margin-right: 24px;
}

h1	{
	font-size: 25px;
}
h2	{
	font-size: 20px;
}
h3	{
	font-size: 16px;
	font-weight: bold;
}
hr	{
	height: 1px;
	border: 0;
	color: #ddd;
	background-color: #ddd;
}

.app-desc {
  clear: both;
  margin-left: 20px;
}
.param-name {
  width: 100%;
}
.license-info {
  margin-left: 20px;
}

.license-url {
  margin-left: 20px;
}

.model {
  margin: 0 0 0px 20px;
}

.method {
  margin-left: 20px;
}

.method-notes	{
	margin: 10px 0 20px 0;
	font-size: 90%;
	color: #555;
}

pre {
  padding: 10px;
  margin-bottom: 2px;
}

.http-method {
 text-transform: uppercase;
}

pre.get {
  background-color: #0f6ab4;
}

pre.post {
  background-color: #10a54a;
}

pre.put {
  background-color: #c5862b;
}

pre.delete {
  background-color: #a41e22;
}

.huge	{
	color: #fff;
}

pre.example {
  background-color: #f3f3f3;
  padding: 10px;
  border: 1px solid #ddd;
}

code {
  white-space: pre;
}

.nickname {
  font-weight: bold;
}

.method-path {
  font-size: 1.5em;
  background-color: #0f6ab4;
}

.up {
  float:right;
}

.parameter {
  width: 500px;
}

.param {
  width: 500px;
  padding: 10px 0 0 20px;
  font-weight: bold;
}

.param-desc {
  width: 700px;
  padding: 0 0 0 20px;
  color: #777;
}

.param-type {
  font-style: italic;
}

.param-enum-header {
width: 700px;
padding: 0 0 0 60px;
color: #777;
font-weight: bold;
}

.param-enum {
width: 700px;
padding: 0 0 0 80px;
color: #777;
font-style: italic;
}

.field-label {
  padding: 0;
  margin: 0;
  clear: both;
}

.field-items	{
	padding: 0 0 15px 0;
	margin-bottom: 15px;
}

.return-type {
  clear: both;
  padding-bottom: 10px;
}

.param-header {
  font-weight: bold;
}

.method-tags {
  text-align: right;
}

.method-tag {
  background: none repeat scroll 0% 0% #24A600;
  border-radius: 3px;
  padding: 2px 10px;
  margin: 2px;
  color: #FFF;
  display: inline-block;
  text-decoration: none;
}
 </style>
  </head>
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
  <li><a href="#searchpeople"><code><span class="http-method">post</span> /people</code></a></li>
  </ul>
  <h4><a href="#Comment">Comment</a></h4>
  <ul>
  <li><a href="#addComment"><code><span class="http-method">post</span> /comment/create</code></a></li>
  <li><a href="#commentListGet"><code><span class="http-method">get</span> /comment/list</code></a></li>
  </ul>
  <h4><a href="#Films">Films</a></h4>
  <ul>
  <li><a href="#movieMovieIdGet"><code><span class="http-method">get</span> /movie/{movieId}</code></a></li>
  <li><a href="#searchInventory"><code><span class="http-method">get</span> /movie</code></a></li>
  </ul>

  <h1><a name="Characters">Characters</a></h1>
  <div class="method"><a name="searchpeople"/>
    <div class="method-path">
    <pre class="post"><code class="huge"><span class="http-method">post</span> /people</code></pre></div>
    <div class="method-notes">By passing in the appropriate options, you can search for
available characters</div>
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
    <h3 class="field-label">Responses</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>{
     "status_code": 200,
     "status_message": "Success",
     "total": 87,
     "total_height": "14123cm makes 463ft and 5560.24 inches"
      results:[ {
          "gender" : "male",
          "name" : "Luke Skywalker",
          "height" : 172.0
        }, {
          "gender" : "male",
          "name" : "Luke Skywalker",
          "height" : 172.0
        } ]
        }</code></pre>
  </div>
  <hr/>
  <h1><a name="Comment">Comment</a></h1>
  <div class="method"><a name="addComment"/>
    <div class="method-path">
    <pre class="post"><code class="huge"><span class="http-method">post</span> /comment/create</code></pre></div>
    <div class="method-notes">Create Comment</div>
    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
      <li><code>required</code></li>
    </ul>
     <pre class="example"><code>
     {
          "comment" : "string" && "max:500",
          "episode_id" : "int" && "1-7",
     }</code></pre>
<h3 class="field-label">Response</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
   <pre class="example"><code>
   {
       "status_code": 200,
       "status_message": "Success",
   }</code></pre>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="commentListGet"/>
    <div class="method-path">
    <pre class="get"><code class="huge"><span class="http-method">get</span> /comment/list</code></pre></div>
    <div class="method-summary">loads all comments (<span class="nickname">commentListGet</span>)</div>
    <h3 class="field-label">Response</h3>
    <ul>
          <li><code>application/json</code></li>
    </ul>
    <pre><code>[ {
  "date_added" : "2019-11-22 09:34:35",
  "comment" : "Star wars 3 is trash",
  "ip_address" : "154.118.70.57"
}, {
  "date_added" : "2019-11-22 09:34:35",
  "comment" : "Star wars 3 is trash",
  "ip_address" : "154.118.70.57"
} ]</code></pre>
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
  
   <pre class="example">
    <code>{
    "status_code": 200,
     "status_message": "Success",
     "results":
     {
           "comments" : 1,
          "release_date" : "2016-08-29",
          "name" : "The Force Awakens",
          "opening_crawl" : "Luke Skywalker has vanished.\\r\\nIn his absence, the sinister\\r\\nFIRST ORDER has risen from\\r\\nthe ashes of the Empire\\r\\nand will not rest until\\r\\nSkywalker, the last Jedi,\\r\\nhas been destroyed.\\r\\n \\r\\nWith the support of the\\r\\nREPUBLIC, General Leia Organa\\r\\nleads a brave RESISTANCE.\\r\\nShe is desperate to find her\\r\\nbrother Luke and gain his\\r\\nhelp in restoring peace and\\r\\njustice to the galaxy.\\r\\n \\r\\nLeia has sent her most daring\\r\\npilot on a secret mission\\r\\nto Jakku, where an old ally\\r\\nhas discovered a clue to\\r\\nLuke's whereabouts....",
          "id" : 7
          }
     }
</code></pre>
  <hr/>
  <div class="method"><a name="searchInventory"/>
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
     results:[ {
      "comments" : 0.80082819046101150206595775671303272247314453125,
      "release_date" : "2016-08-29",
      "name" : "The Force Awakens",
      "opening_crawl" : "Luke Skywalker has vanished.\\r\\nIn his absence, the sinister\\r\\nFIRST ORDER has risen from\\r\\nthe ashes of the Empire\\r\\nand will not rest until\\r\\nSkywalker, the last Jedi,\\r\\nhas been destroyed.\\r\\n \\r\\nWith the support of the\\r\\nREPUBLIC, General Leia Organa\\r\\nleads a brave RESISTANCE.\\r\\nShe is desperate to find her\\r\\nbrother Luke and gain his\\r\\nhelp in restoring peace and\\r\\njustice to the galaxy.\\r\\n \\r\\nLeia has sent her most daring\\r\\npilot on a secret mission\\r\\nto Jakku, where an old ally\\r\\nhas discovered a clue to\\r\\nLuke's whereabouts....",
      "id" : 7.0
    }, {
      "comments" : 0,
      "release_date" : "2016-08-29",
      "name" : "The Force Awakens",
      "opening_crawl" : "Luke Skywalker has vanished.\\r\\nIn his absence, the sinister\\r\\nFIRST ORDER has risen from\\r\\nthe ashes of the Empire\\r\\nand will not rest until\\r\\nSkywalker, the last Jedi,\\r\\nhas been destroyed.\\r\\n \\r\\nWith the support of the\\r\\nREPUBLIC, General Leia Organa\\r\\nleads a brave RESISTANCE.\\r\\nShe is desperate to find her\\r\\nbrother Luke and gain his\\r\\nhelp in restoring peace and\\r\\njustice to the galaxy.\\r\\n \\r\\nLeia has sent her most daring\\r\\npilot on a secret mission\\r\\nto Jakku, where an old ally\\r\\nhas discovered a clue to\\r\\nLuke's whereabouts....",
      "id" : 7.0
    } ]
    }</code></pre>
  </div> <!-- method -->
  <hr/>
  
<h3 class="field-label">Errors</h3>
<pre class="example"><code>
   {
       "status_code": 401,
       "status_message": "API Error",
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
      
      
 
 

  