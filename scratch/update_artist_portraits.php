<?php
require_once 'config.php';

$artist_images = [
    'Sinach' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=400',
    'Matt Redman' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=400',
    'Chris Tomlin' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=400',
    'Hillsong United' => 'https://images.unsplash.com/photo-1514525253344-f814d0743b17?auto=format&fit=crop&q=80&w=400',
    'Maverick City Music' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&q=80&w=400',
    'Elevation Worship' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&q=80&w=400',
    'Tasha Cobbs Leonard' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=400',
    'CeCe Winans' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=400',
    'Kirk Franklin' => 'https://images.unsplash.com/photo-1516280440614-37939bbacd81?auto=format&fit=crop&q=80&w=400',
    'Brandon Lake' => 'https://images.unsplash.com/photo-1498038432885-c6f3f1b912ee?auto=format&fit=crop&q=80&w=400',
    'Phil Wickham' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&q=80&w=400',
    'Nathaniel Bassey' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&q=80&w=400',
    'Moses Bliss' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=400',
    'Mercy Chinwo' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=400',
    'Ada Ehi' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=400',
    'Todd Dulaney' => 'https://images.unsplash.com/photo-1516280440614-37939bbacd81?auto=format&fit=crop&q=80&w=400',
    'Travis Greene' => 'https://images.unsplash.com/photo-1459749411177-042180ce673f?auto=format&fit=crop&q=80&w=400',
    'Cory Asbury' => 'https://images.unsplash.com/photo-1514525253344-f814d0743b17?auto=format&fit=crop&q=80&w=400',
    'Chandler Moore' => 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?auto=format&fit=crop&q=80&w=400',
    'Dante Bowe' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&q=80&w=400',
    'Casting Crowns' => 'https://images.unsplash.com/photo-1498038432885-c6f3f1b912ee?auto=format&fit=crop&q=80&w=400',
    'Lauren Daigle' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&q=80&w=400',
    'for KING & COUNTRY' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&q=80&w=400',
    'Dunsin Oyekan' => 'https://images.unsplash.com/photo-1514320298574-2c9d81791a50?auto=format&fit=crop&q=80&w=400',
];

$updated = 0;
foreach ($artist_images as $artist => $image) {
    $stmt = $pdo->prepare("UPDATE music SET cover_image_url = ? WHERE artist = ?");
    $stmt->execute([$image, $artist]);
    $updated += $stmt->rowCount();
}

echo "Successfully updated artist portraits for $updated tracks!\n";
?>
