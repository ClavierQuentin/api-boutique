<h1>Numéro de commande : {{ $details['commande']->id }}</h1>

<p>Date de la commande : {{ $details['commande']->date_order->format('d/m/Y') }}</p>

@foreach ($details['items'] as $item)
    <img src="{{ $item->image_url }}">
@endforeach

<p>Total de la commande : {{ $details['total'] }}€</p>
