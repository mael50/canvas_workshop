---
sidebar_label: Modèle de données
sidebar_position: 2
---

# Modèle de Données - MyVectorCanvas

Le modèle de données de l'application MyVectorCanvas est conçu pour stocker les informations relatives aux templates, éléments, couleurs, images, textes, et QR codes utilisés dans la création de designs personnalisés. Voici un aperçu des entités principales et de leurs relations :

```mermaid
erDiagram
    TEMPLATE {
        int id PK
        string name
        double width
        double height
        datetime created_at
        datetime updated_at
        string preview_url
    }

    ELEMENT {
        int id PK
        double pos_x
        double pos_y
        double width
        double height
        string input_associe
        string type
        int template_id FK
    }

    COLOR {
        int id PK
        string code_hexa
    }

    IMAGE {
        int id PK
        string src
        string name
    }

    TEXT {
        int id PK
        string text_color
        string background_color
        string placeholder
        string align
        bool bold
        bool italic
        double font_size
        string font_family
    }

    QRCODE {
        int id PK
        string text
    }

    TEMPLATE_COLOR {
        int template_id FK
        int color_id FK
    }

    TEMPLATE ||--o{ ELEMENT : contains
    ELEMENT ||--|{ IMAGE : "inherits"
    ELEMENT ||--|{ TEXT : "inherits"
    ELEMENT ||--|{ QRCODE : "inherits"
    TEMPLATE_COLOR ||--o| TEMPLATE : "has"
    TEMPLATE_COLOR ||--o| COLOR : "includes"
```