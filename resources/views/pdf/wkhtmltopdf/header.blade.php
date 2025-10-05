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
        
        .header-container {
            width: 100%;
            text-align: center;
            padding: 20px 0 10px 0;
            background: white;
            margin-top: 20px;
        }
        
        .header-image {
            width: 90%;
            max-width: 500px;
            height: auto;
            max-height: 120px;
            display: block;
            margin: 0 auto 5px auto;
            object-fit: contain;
        }
        
        .office-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin: 5px 0;
            text-align: center;
        }
        
        .two-tone-line {
            width: 100%;
            height: 3px;
            background: linear-gradient(to right, #FFD700 0%, #FFD700 50%, #0066CC 50%, #0066CC 100%);
            margin: 2px 0;
        }
    </style>
</head>
<body>
    @php
        $header = base64_encode(file_get_contents(public_path('images/header.png')));
    @endphp
    
    <div class="header-container">
        <img src="data:image/png;base64,{{ $header }}" alt="University Header" class="header-image" />
        <h3 class="office-title">OFFICE OF STUDENT AFFAIRS</h3>
        <div class="two-tone-line"></div>
    </div>
</body>
</html>
