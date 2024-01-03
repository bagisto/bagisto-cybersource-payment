<html>
<head>
    <title>Secure Acceptance - Payment Form</title>
</head>
<body>
    <h1>Please do not refresh this page...</h1>

    <form action="{{ $CYBERSOURCE_URL }}" id="paymentForm" method="POST">
        <input value="Click here if you are not redirected within 10 seconds..." type="submit">

        @foreach ($params as $name => $value)

            <input type="hidden" name="{{ $name }}" value="{{ $value }}">

        @endforeach
    </form>

    <script type="text/javascript">
        document.getElementById("paymentForm").submit();
    </script>
</body>
</html>
