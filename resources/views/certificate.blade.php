<!DOCTYPE html>
<html>
<head>
    <title>Certificate</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .certificate { border: 10px solid #000; padding: 20px; }
        h1 { font-size: 40px; }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>Certificate of Completion</h1>
        <p>This certifies that</p>
        <h2>{{ $result->user->name }}</h2>
        <p>has successfully completed the quiz <strong>{{ $result->quiz->title }}</strong>
           with a score of {{ $result->score }}/{{ $result->quiz->questions->count() }}.</p>
    </div>
</body>
</html>
