<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<style>
        body{
            background: #3490dc;
        }
        input,
        button,
        select,
        optgroup,
        textarea {
          margin: 0;
          font-family: inherit;
          font-size: inherit;
          line-height: inherit;
        }
        textarea.form-control {
          height: auto;
        }
        
        .text-primary {
          color: #3490dc !important;
        }
        .container {
          width: 100%;
          padding-right: 15px;
          padding-left: 15px;
          margin-right: auto;
          margin-left: auto;
        }
        .form-group {
          margin-bottom: 1rem;
        }
        .form-control {
          display: block;
          width: 100%;
          height: calc(1.6em + 0.75rem + 2px);
          padding: 0.375rem 0.75rem;
          font-size: 0.9rem;
          font-weight: 400;
          line-height: 1.6;
          color: #495057;
          background-color: #fff;
          background-clip: padding-box;
          border: 1px solid #ced4da;
          border-radius: 0.25rem;
          transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        @media (prefers-reduced-motion: reduce) {
        .form-control {
            transition: none;
        }
        }

</style>
</head>
<body>

    <h1 class="text-primary">Nuevo contacto</h1>
    <p> Nombre: {{ $msg['name'] }}</p>
    <p>Email: {{ $msg['email'] }}</p>
    <p>Asunto: {{ $msg['subject'] }}</p>
    <p>Número: {{ $msg['number'] }}</p>
    <p>Mensaje: {{ $msg['message'] ?? '' }}</p>

</body>
</html>
