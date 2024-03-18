<html>
    <head>
        <title>
            @lang('cyber_source::app.shop.payment.title')
        </title>
    </head>

    <body>
        <h1>
            @lang('cyber_source::app.shop.payment.alert-msg')
        </h1>

        <form 
            action="{{ $cyberSourceUrl }}" 
            id="paymentForm" 
            method="POST"
        >
            <input 
                value="@lang('cyber_source::app.shop.payment.redirect-msg')"
                type="submit"
            />

            @foreach ($params as $name => $value)
                <input 
                    type="hidden" 
                    name="{{ $name }}" 
                    value="{{ $value }}"
                />
            @endforeach
        </form>

        <script type="text/javascript">
            document.getElementById("paymentForm").submit();
        </script>
    </body>
</html>
