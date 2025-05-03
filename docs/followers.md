# Followers API

Endpoints to follow, unfollow, and retrieve user follow data.

---

## POST /followers/followUser.php

Follows a user. Requires authentication.

### Headers
- `Content-Type`: application/json  
- `X-Access-Token`: Bearer token

### Body
```json
{
  "user_id": 14
}
```

### Responses
- `201 Created` – Followed successfully
- `409 Conflict` – Already following
- `400 Bad Request` – Cannot follow yourself
- `401 Unauthorized` – Token missing or invalid

---

## DELETE /followers/unfollowUser.php

Unfollows a user. Requires authentication.

### Headers
- `Content-Type`: application/json  
- `X-Access-Token`: Bearer token

### Body
```json
{
  "user_id": 14
}
```

### Responses
- `200 OK` – Unfollowed successfully
- `404 Not Found` – You were not following this user
- `401 Unauthorized` – Token missing or invalid

---

## GET /followers/getFollowers.php?user_id=14

Returns a list of users following the specified user.

### Query Parameters
- `user_id`: ID of the user

### Response
```json
[
  {
    "user_id": 13,
    "username": "MusicManiac"
  },
  {
    "user_id": 12,
    "username": "Jazzlover42"
  }
]
```

---

## GET /followers/getFollowing.php?user_id=13

Returns a list of users the specified user is following.

### Query Parameters
- `user_id`: ID of the user

### Response
```json
[
  {
    "following_user_id": 14,
    "username": "RapStarr"
  }
]
```
