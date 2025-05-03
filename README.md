# Speakeasy Sounds – RESTful API  
This project is a secure, modular API backend built for **Speakeasy Sounds**, a social music-sharing platform. Built using PHP (PDO), MAMP, and Postman for testing, the API allows users to register, log in, share posts, interact via comments and likes, and follow each other.

## Folder Structure

/api
/posts
/users
/comments
/likes
/followers
validate_token.php
/db
Database.phpx

## Features

### Authentication
- Register new users
- Secure login with Base64 token
- Token validation middleware (`validate_token.php`)

### Posts
- `GET /posts/getAllPosts.php` – Get all posts
- `GET /posts/getPost.php?post_id={id}` – Get single post by ID
- `POST /posts/createPost.php` – Create a new post (auth)
- `PATCH /posts/updatePost.php` – Update own post (auth)
- `DELETE /posts/deletePost.php` – Delete own post (auth)

### Comments
- `POST /comments/createComment.php` – Add a comment (auth)
- `GET /comments/getCommentsByPost.php?post_id={id}` – Get comments by post
- `PATCH /comments/updateComment.php` – Edit own comment (auth)
- `DELETE /comments/deleteComment.php` – Delete own comment (auth)

### Likes
- `POST /likes/likePost.php` – Like a post (auth)
- `DELETE /likes/unlikePost.php` – Unlike a post (auth)
- `GET /likes/getLikesByPost.php?post_id={id}` – Get likes on a post

### Followers
- `POST /followers/followUser.php` – Follow another user (auth)
- `DELETE /followers/unfollowUser.php` – Unfollow user (auth)
- `GET /followers/getFollowers.php?user_id={id}` – Get a user's followers
- `GET /followers/getFollowing.php?user_id={id}` – Get users a user is following

### Spotify Integration
- `GET /spotify/searchTracks.php?q={tag}` – Search for tracks via Spotify (used for track suggestions)


## Testing & Development

- All endpoints tested using **Postman** (saved as collections)
- Validated using real tokens
- Token required for secure endpoints via `X-Access-Token: Bearer <token>`
- Database structure loaded via `speakeasysounds.sql`

## Documentation

Full API documentation site is available using **MkDocs** in the `/docs` folder.

## Tech Stack

- PHP 8.3 with PDO
- MySQL (MariaDB via MAMP)
- Postman for REST testing
- Git & GitHub for version control
- MkDocs for developer documentation

## Author

Marcus Mallia  
MCAST – B.A. Hons in Interactive Digital Media  
GitHub: [MarcusMallia](https://github.com/MarcusMallia)

