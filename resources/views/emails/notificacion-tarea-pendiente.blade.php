@component('mail::message')

Se te envió este mensaje para recordarte del trabajo o vencimiento pendiente. 


@component('mail::button', ['url' => $tareaPendiente->urlDeEntidad()])

@if($tareaPendiente->esDeVehiculo())
Ver vehículo
@elseif($tareaPendiente->esDeChofer())
Ver chofer
@endif

@endcomponent


Saludos,<br>
{{ config('app.name') }}
@endcomponent