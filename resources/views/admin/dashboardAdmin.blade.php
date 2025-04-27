<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tableau de Bord Administrateur</title>
    </head>
    <body>
        <h1>Tableau de Bord Administrateur</h1>

        <p>Bienvenue, {{ Auth::user()->name }} ! (administrateur)</p>

        <form method="POST" action="/logout">
            @csrf
            <button type="submit">Se déconnecter</button>
        </form>

        </body>
    </html>