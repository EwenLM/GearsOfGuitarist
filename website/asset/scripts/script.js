const clientId = 'YourSpotifyDevId';
const clientSecret = 'YourSpotifySecretId';
const authUrl = 'https://accounts.spotify.com/api/token';


const data = {
  grant_type: 'client_credentials',
  client_id: clientId,
  client_secret: clientSecret
};

fetch(authUrl, {
  method: 'POST',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded'
  },
  body: new URLSearchParams(data)
})
.then(response => response.json())
.then(tokenData => {
  const accessToken = tokenData.access_token;
  const artistUrl = `https://api.spotify.com/v1/artists/${artistId}`;
  const topTracksUrl = `https://api.spotify.com/v1/artists/${artistId}/top-tracks?country=FR`;

  // Demande les données de l'artiste
  fetch(artistUrl, {
    headers: {
      'Authorization': `Bearer ${accessToken}`
    }
  })
  .then(response => response.json())
  .then(artistData => {
    console.log('Données de l\'artiste : ', artistData);

    // Affiche l'image de l'artiste
    const artistImg = artistData.images[2].url;
    const imgArtist = document.querySelector('#info .imgSpotify');
    const img = document.createElement('img');
    img.src = artistImg;
    img.classList.add('imgArtist');
    imgArtist.appendChild(img);
  })
  .catch(error => console.error(error));

  // Demande les top tracks de l'artiste
  fetch(topTracksUrl, {
    headers: {
      'Authorization': `Bearer ${accessToken}`
    }
  })
  .then(response => response.json())
  .then(data => {
    // Vérifie si les données contiennent des top tracks
    if (!data.tracks || data.tracks.length === 0) {
      console.error('Aucune top track trouvée');
      return;
    }
    
    // Récupère les IDs des 5 premières musiques 
    const first5TrackIDs = data.tracks.slice(0, 5).map(track => track.id);
    
    // Affiche les IDs des 5 premières musiques
    console.log('IDs des 5 premières musiques : ', first5TrackIDs);

    const trackContainer = document.querySelector('#topFive');
    data.tracks.slice(0, 5).forEach(track => {
      const iframe = document.createElement('iframe');
      iframe.src = `https://open.spotify.com/embed/track/${track.id}?utm_source=generator`;
      iframe.width = '100%';
      iframe.height = '152';
      iframe.frameBorder = '0';
      iframe.allowFullscreen = true;
      iframe.allow = 'autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture';
      iframe.loading = 'lazy';
      iframe.style.borderRadius = '12px';
      trackContainer.appendChild(iframe);
    });
  })
  })
  .catch(error => console.error(error));

