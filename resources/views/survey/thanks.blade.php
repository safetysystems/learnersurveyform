

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Thankyou</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
                <div class="py-5">
        <div class="text-center mb-4">
            <h1 class="h3 mb-3">Thank you for sharing your views.</h1>
            <p class="text-muted mb-0">Your responses have been recorded.</p>
        </div>

        @isset($form)
            <div class="text-center">
                <p class="mb-2">
                    You may download a copy of your answers for your records.
                </p>
                <a href="{{ route('survey.response.download', $form) }}" class="btn btn-outline-primary">
                    Download my responses
                </a>
            </div>
        @endisset
    </div>

    </body>
    </html>

