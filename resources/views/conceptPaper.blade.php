<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Konzeptpapier</title>
    <link href=" {{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f04c8c4f04.js" crossorigin="anonymous"></script>
</head>

<body>
    <div>
        <div class="col-md-4">
                <div>
                    <div class="new">
                        Paper: {{$conceptPaper->name}}
                    </div>
                </div>
            </a>
        </div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>