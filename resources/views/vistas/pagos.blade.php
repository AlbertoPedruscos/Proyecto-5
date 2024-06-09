<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
    <link rel="stylesheet" href="./css/pagos.css">  
</head>
<body>
    <div class="container mt-5">
        <a href="{{ route('inicio') }}" class="btn btn-primary" style="float: right">Volver</a>
        <h2 class="mb-4">Pagar la suscripcion mensual</h2>

            @if(session('success_message'))
                <div class="alert alert-success">
                    {{ session('success_message') }}
                </div>
            @endif
            @if(session('error_message'))
                <div class="alert alert-danger">
                    {{ session('error_message') }}
                </div>
            @endif


        <form action="{{ route('processPayment') }}" method="POST" id="payment-form">
            @csrf
            <div class="form-group">
                <label for="card-number-element">Número de Tarjeta</label>
                <div id="card-number-element" class="form-control">
                    <!-- Un Stripe Element se insertará aquí. -->
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="card-expiry-element">Fecha de Vencimiento</label>
                    <div id="card-expiry-element" class="form-control">
                        <!-- Un Stripe Element se insertará aquí. -->
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="card-cvc-element">CVC</label>
                    <div id="card-cvc-element" class="form-control">
                        <!-- Un Stripe Element se insertará aquí. -->
                    </div>
                </div>
            </div>
            <div id="card-errors" role="alert" class="text-danger mt-2"></div>
            <button type="submit" class="btn btn-primary">Enviar Pago</button>
        </form>
    </div>
</body>
</html>
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ config('services.stripe.key') }}');
    var elements = stripe.elements();
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    var cardNumber = elements.create('cardNumber', {style: style});
    var cardExpiry = elements.create('cardExpiry', {style: style});
    var cardCvc = elements.create('cardCvc', {style: style});

    cardNumber.mount('#card-number-element');
    cardExpiry.mount('#card-expiry-element');
    cardCvc.mount('#card-cvc-element');

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(cardNumber).then(function(result) {
            if (result.error) {
                // Informar al usuario si hubo un error
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Enviar el token al servidor
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', result.token.id);
                form.appendChild(hiddenInput);

                form.submit();
            }
        });
    });
</script>
