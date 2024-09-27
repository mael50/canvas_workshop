---
sidebar_label: API et Interfaces
sidebar_position: 3
---

# API et Interfaces

Voici la documentation de votre route d'API au format Markdown :

---

# API Documentation

## Overview
Cette API permet de récupérer les données d'un template spécifique, y compris ses éléments associés tels que les couleurs, les textes, les images et les QR codes. Elle utilise une requête GET pour extraire les informations détaillées d'un template, offrant ainsi la possibilité aux clients d'afficher ou de manipuler ces données.

---

## **Endpoint: Récupérer un Template par ID**

- **URL** : `/api/template/{id}`
- **Méthode** : `GET`
- **Description** : Cet endpoint permet de récupérer les informations d'un template en fonction de l'ID fourni.

### Paramètres

| Paramètre | Type     | Description                             | Obligatoire |
|-----------|----------|-----------------------------------------|-------------|
| `id`      | `integer`| L'ID du template à récupérer.           | Oui         |

### Réponse

La réponse contient les détails du template, ses couleurs, textes, images et QR codes associés.

#### Exemple de Réponse (200 OK)

```json
{
  "id": 1,
  "name": "Test Template",
  "width": 100,
  "height": 100,
  "colors": [
    {
      "id": 7,
      "codeHexa": "#FF0000"
    },
    {
      "id": 8,
      "codeHexa": "#000000"
    }
  ],
  "text": [
    {
      "id": 6,
      "posX": 246,
      "posY": 186,
      "width": 100,
      "height": 100,
      "content": "Sample text",
      "fontSize": 12,
      "fontColor": "#FFFFFF"
    }
  ],
  "images": [
    {
      "id": 4,
      "posX": 100,
      "posY": 100,
      "width": 100,
      "height": 100,
      "src": "test.png",
      "name": "Test Image"
    }
  ],
  "qrCodes": [
    {
      "id": 8,
      "posX": 459,
      "posY": 201,
      "width": 200,
      "height": 200,
      "text": "Sample QR Code"
    }
  ]
}
```

### **Champs**

- **Champs du Template :**
  - `id` : Identifiant unique du template.
  - `name` : Nom du template.
  - `width` : Largeur du template.
  - `height` : Hauteur du template.
  
- **Champs des Couleurs :**
  - `id` : Identifiant unique de la couleur.
  - `codeHexa` : Le code couleur hexadécimal.

- **Champs du Texte :**
  - `id` : Identifiant unique de l'élément texte.
  - `posX` : Position sur l'axe X du texte.
  - `posY` : Position sur l'axe Y du texte.
  - `width` : Largeur de la boîte de texte.
  - `height` : Hauteur de la boîte de texte.
  - `content` : Le contenu texte réel.
  - `fontSize` : Taille de la police.
  - `fontColor` : La couleur du texte.
  
- **Champs des Images :**
  - `id` : Identifiant unique de l'image.
  - `posX` : Position sur l'axe X de l'image.
  - `posY` : Position sur l'axe Y de l'image.
  - `width` : Largeur de l'image.
  - `height` : Hauteur de l'image.
  - `src` : Chemin ou URL de l'image.
  - `name` : Nom de l'image.

- **Champs des QR Codes :**
  - `id` : Identifiant unique du QR code.
  - `posX` : Position sur l'axe X du QR code.
  - `posY` : Position sur l'axe Y du QR code.
  - `width` : Largeur du QR code.
  - `height` : Hauteur du QR code.
  - `text` : Le texte contenu dans le QR code.

--- 

Cela devrait fournir une base claire pour comprendre l'API et ses fonctionnalités.