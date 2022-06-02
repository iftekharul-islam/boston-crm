<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 8 Import Export Excel & CSV File - TechvBlogs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
<div class="container mt-5 text-center">
    <h2 class="mb-4">
        Import Client Excel & CSV File
    </h2>
    <form action="{{ route('import-client') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-4">
            <div class="custom-file text-left">
                <input type="file" name="file" accept="application/octet-stream,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="custom-file-input" id="client-file">
                <label class="custom-file-label" for="customFile">Choose file</label>
                <span class="text text-warning file-name">Please Upload a valid file</span>
            </div>
        </div>
        <button class="btn btn-primary">Import Clients</button>
    </form>
</div>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $('#client-file').on('change', function(){
        let filename = $(this).val().replace(/C:\\fakepath\\/i, '');
        $('.file-name').text(filename);
    });
</script>
