# Comments API

Endpoints for interacting with comments on posts.

---

## POST /comments/createComment.php

Adds a comment to a post. Requires authentication.

### Headers
- `Content-Type`: application/json  
- `X-Access-Token`: Bearer token

### Body
```json
{
  "post_id": 16,
  "content": "Great track!"
}
```

### Responses
- `201 Created` – Comment added
- `400 Bad Request` – Missing post_id or content
- `401 Unauthorized` – Invalid or missing token

---

## GET /comments/getCommentsByPost.php?post_id=16

Returns all comments for a specific post.

### Query Parameters
- `post_id`: ID of the post

### Response
```json
[
  {
    "comment_id": 1,
    "user_id": 13,
    "content": "Great song!",
    "created_at": "2025-04-30 12:34:00"
  }
]
```

---

## PATCH /comments/updateComment.php

Updates a comment. Requires authentication and ownership.

### Headers
- `Content-Type`: application/json  
- `X-Access-Token`: Bearer token

### Body
```json
{
  "comment_id": 12,
  "new_content": "Edited comment content"
}
```

---

## DELETE /comments/deleteComment.php

Deletes a comment. Requires authentication and ownership.

### Headers
- `Content-Type`: application/json  
- `X-Access-Token`: Bearer token

### Body
```json
{
  "comment_id": 12
}
```
