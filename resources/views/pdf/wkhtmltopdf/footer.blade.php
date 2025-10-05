<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', serif;
            background: white;
        }
        
        .footer-container {
            width: 100%;
            text-align: center;
            padding: 10px 0;
            background: white;
        }
        
        .two-tone-line {
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, #FFD700 0%, #FFD700 50%, #0066CC 50%, #0066CC 100%);
            margin: 5px 0;
        }
        
        .footer-image {
            width: 100%;
            height: auto;
            display: block;
            margin-bottom: 50px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    @php
        $footer = base64_encode(file_get_contents(public_path('images/footer.png')));
    @endphp
    
    <div class="footer-container">
        <div class="two-tone-line"></div>
        <img src="data:image/png;base64,{{ $footer }}" alt="Footer" class="footer-image" />
    </div>
</body>
</html>
