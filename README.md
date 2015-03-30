# checkin
Un exemple simple d'outil de gestion de données en PHP/Mysql

## Adresse du dépôt
https://github.com/theyoux/checkin

##Table event

| Champs| Description| Type |
|------|--------------------|--------|
| id | Clé primaire | integer |
| name | Nom de l'événement | string |
| description | Description | text |
| address | Adresse de l'événement | text |
| latitude | Latitude | float |
| longitude | Longitude | float |
| date_begin | Date de début | datetime |
| date_end | Date de fin | datetime |
| picture | Illustration | string |
| price | Prix d'entrée | float |
| url | Information à consulter | string |
| type | Type d'événement | string |
| phone | Téléphone | string |
| email | Email du responsable | string |
| max_places | Nombre maximum de places | integer |
| published | Permet de publier l'événement | integer (0 ou 1) |


##Table contact

| Champs| Description| Type |
|------|--------------------|--------|
| id | Clé primaire | integer |
| gender | Civilité | string (m ou f) |
| firstname | Prénom de la personne | string |
| lastname | Nom de la personne | string |
| birthday | Date de naissance | date |
| phone | Téléphone | string |
| email | Email du responsable | string |
| address | Adresse sans la ville et le code postal | string |
| zipcode | Code postal | string |
| city | Ville | string |
| created_at | Date de création | datetime |


##Table event_contact

| Champs| Description| Type |
|-------|------------|------|
| event_id | Clé étrangère vers Event | integer |
| contact_id | Clé étrangère vers Contact | integer |
| places | Nombre de places | integer |
| booked_at | Date de la réservation | datetime |
| amount | Montant de la réservation | float |
| payed_at | Date du règlement | datetime |
