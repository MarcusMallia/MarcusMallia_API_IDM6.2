# Spotify Integration

This API connects with Spotify to search for tracks and suggest music.

## Endpoints

| Method | Endpoint | Purpose |
|--------|----------|---------|
| GET | `/api/external/searchSpotifyTrack.php?query={term}` | Search Spotify by keyword |
| GET | `/api/external/suggestTracksByTags.php?tags={tag1,tag2}` | Suggest tracks based on post tags |

All Spotify data is fetched live using cURL.