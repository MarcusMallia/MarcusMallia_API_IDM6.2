# Posts API

Endpoints related to posting and managing music posts.

## Endpoints

| Method | Endpoint | Purpose | Requires Token? |
|--------|----------|---------|-----------------|
| GET | `/api/posts/getAllPosts.php` | Retrieve all posts | No |
| GET | `/api/posts/getSinglePost.php?id={id}` | Retrieve single post by ID | No |
| POST | `/api/posts/createPost.php` | Create a new post | Yes |
| PATCH | `/api/posts/updatePost.php` | Update existing post | Yes |
| DELETE | `/api/posts/deletePost.php` | Delete a post | Yes |