<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Istanbul Gourmet Market - Premium Turkish and Canadian products with authentic flavors. Located in Windsor, Ontario.">
    <meta name="keywords" content="Turkish products, gourmet market, Canadian favorites, authentic flavors, Windsor Ontario">
    <meta name="author" content="Istanbul Gourmet Market">
    <meta name="theme-color" content="#f31e45">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="business.business">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Istanbul Gourmet Market">
    <meta property="og:description" content="Premium Turkish and Canadian products with authentic flavors">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="Istanbul Gourmet Market">
    <meta property="twitter:description" content="Premium Turkish and Canadian products with authentic flavors">
    
    <!-- Accessibility -->
    <meta name="color-scheme" content="light dark">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url('/') }}">
    
    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <title>Istanbul Gourmet Market - Turkish & Canadian Gourmet Products | Windsor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body role="document">
    <div id="app" role="main"></div>
    
    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Istanbul Gourmet Market",
      "description": "Premium Turkish and Canadian gourmet products",
      "url": "{{ url('/') }}",
      "telephone": "+1 (226) 220-9492",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Tecumseh Road",
        "addressLocality": "Windsor",
        "addressRegion": "Ontario",
        "postalCode": "N9A",
        "addressCountry": "CA"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 42.3119234,
        "longitude": -82.9454712
      },
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
          "opens": "10:00",
          "closes": "20:00"
        },
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": "Sunday",
          "opens": "11:00",
          "closes": "18:00"
        }
      ]
    }
    </script>
</body>
</html>