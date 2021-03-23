<?php


namespace App\Service;


/**
 * @return String
 */
class YoutubeDeveloperKeyGenerator
{
    public function DeveloperKeyGenerator() : String
    {
        return "AIzaSyB6jlKn0q2QDja0YQG_4fcmJ7g_wwLHP6c";
    }

    //Etant donné que nous sommes limités avec un systeme de quota par google pour nos requetes
    //Cette fonction permettera à l'avenir d'avoir plusieurs clés et donc à chaque recherche
    //On prendra aléatoirement une clé et les chances d'etre à cours de quota seront donc beaucoup plus faibles
}
