<h1>Commande passée le {{ $details['commande']->date_order->format('d/m/Y') }} par {{ $details['user']->name }}</h1>
<P>Montant totale de la commande :  {{ $details['total'] }}€</P>
