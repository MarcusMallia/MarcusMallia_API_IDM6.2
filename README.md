Of course! Here’s the full README.md text for your project — clean, no emojis, no sections missing, all together, ready for professional GitHub use:

⸻

SpeakeasySounds API

A RESTful PHP API backend for a music sharing platform that allows users to register, log in, upload music posts, interact with Spotify, and explore related tracks.
Designed with future integration of frontend or mobile applications in mind.

Project Overview
	•	Built using PHP and MySQL.
	•	Secure token-based authentication system (via X-Access-Token header).
	•	CRUD operations for Posts (Create, Read, Update, Delete).
	•	External integration with the Spotify API using cURL.
	•	Fully documented using Postman collections and MkDocs.

Project Structure

MarcusMallia_API_IDM6.2/
├── api/
│   ├── db/
│   │   └── Database.php
│   ├── posts/
│   │   ├── createPost.php
│   │   ├── deletePost.php
│   │   ├── getAllPosts.php
│   │   ├── getSinglePost.php
│   │   ├── updatePost.php
│   ├── users/
│   │   ├── registerUser.php
│   │   ├── loginUser.php
│   ├── external/
│   │   ├── searchSpotifyTrack.php
│   │   ├── suggestTracksByTags.php
│   └── validate_token.php
├── postman/
│   └── SpeakeasySounds_API_Collection.json
├── .gitignore
└── README.md

Authentication
	•	Login returns a token (X-Access-Token).
	•	Token is required for:
	•	Creating posts
	•	Updating posts
	•	Deleting posts
	•	Token is validated on every protected request.

Third-Party Integration
	•	Integrated with Spotify API via Client Credentials OAuth flow.
	•	Track search and suggestions available through:
	•	searchSpotifyTrack.php?query={search_term}
	•	suggestTracksByTags.php?tags={tag1,tag2}

Postman Collection
	•	All endpoints are saved in /postman/SpeakeasySounds_API_Collection.json
	•	Can be imported into Postman to test and explore the API.

How to Set Up Locally
	1.	Install MAMP or any local server.
	2.	Import speakeasysounds_api.sql into your MySQL database.
	3.	Clone this repo into your local server’s root directory (htdocs/ for MAMP).
	4.	Create a spotify_config.php inside api/external/ with your own Spotify Client ID and Secret.
	5.	Start MAMP servers.
	6.	Access endpoints at:
http://localhost:8888/MarcusMallia_API_IDM6.2/api/


