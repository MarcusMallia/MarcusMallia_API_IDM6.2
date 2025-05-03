# Likes API

Endpoints to like, unlike, and view likes on posts.

---

## POST /likes/likePost.php

Likes a post. Requires authentication.

### Headers
- `Content-Type`: application/json  
- `X-Access-Token`: Bearer token

### Body
```json
{
  "post_id": 16
}
```

### Responses
- `201 Created` – Liked successfully
- `409 Conflict` – Post already liked
- `401 Unauthorized` – Token missing or invalid

---

## DELETE /likes/unlikePost.php

Unlikes a post. Requires authentication.

### Headers
- `Content-Type`: application/json  
- `X-Access-Token`: Bearer token

### Body
```json
{
  "post_id": 16
}
```

### Responses
- `200 OK` – Unliked successfully
- `404 Not Found` – Post not previously liked
- `401 Unauthorized` – Token missing or invalid

---

## GET /likes/getLikesByPost.php?post_id=16

Retrieves a list of users who liked a post.

### Query Parameters
- `post_id`: ID of the post

### Response
```json
[
  {
    "user_id": 12,
    "username": "Jazzlover42"
  },
  {
    "user_id": 13,
    "username": "MusicManiac"
  }
]
```
