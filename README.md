# TP2_Version2

## Utiliser la branche Master ou la MML_Light pour corriger. 
Il y a aussi la branche IndexOnly_Light qui possède seulement une page index.php et pas de site web complet. Mais je ne l'ai pas revalider...


Liste des commandes utilisées:

| Utilisation | Commande | Explication |
| ----------- | ----------- | ----------- |
| Lancer les conteneurs     | docker-compose up --build -d | Démarre les containers en mode Detach en prenant soins de tous les reconstruire .|
| Voir les logs V1          | docker-compose logs | Voir tous les logs des conteneurs actifs. |
| Voir les logs V2          | docker-compose logs \| grep  serveur2_1 | Voir les logs d'un seul containeur en nommant son nom. |
| Voir les logs V3 | docker container logs tp2_version2_serveur2_1 | Voir les logs d'un seul containeur en nommant son nom. |
| Arrêter et effacer les images V1 | docker-compose down --rmi local | Toutes les images créées à partir de dockerfile avec la commande 'docker-compose up' seront effacés. Les images provenant de Docker Hub ne seront pas effacées. Tous les containers démarrés avec la commande 'docker-compose up' seront arrêtés. |
| Arrêter et effacer les images V2 | docker-compose down --rmi all | Toutes les images créées avec la commande 'docker-compose up' seront effacés. Les images provenant de Docker Hub seront également effacées. Tous les containers démarrés avec la commande 'docker-compose up' seront arrêtés. |