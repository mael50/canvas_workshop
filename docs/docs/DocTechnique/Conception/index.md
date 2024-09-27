---
sidebar_label: Structure du projet
sidebar_position: 1
---

# Structure du Projet

Le projet **MyVectorCanvas** est structuré pour suivre les meilleures pratiques de développement avec Symfony et inclure les technologies front-end nécessaires. Voici un aperçu de la structure des répertoires et des fichiers principaux du projet.

## Arborescence des Dossiers

```plaintext
MyVectorCanvas/
├── assets/
│   ├── controllers/
│   │   └── form_controller.js
│   ├── styles/
│   │   └── app.css
│   └── app.js
├── bin/
├── config/
├── migrations/
├── public/
│   ├── uploads/
│   ├── images/
│   ├── index.php
│   └── favicon.ico
├── src/
│   ├── ApiResource/
│   ├── Controller/
│   │   ├── Api/
│   │   │   └── TemplateController.php
│   │   ├── ColorsController.php
│   │   ├── ElementController.php
│   │   ├── CreateTemplateController.php
│   │   ├── FormController.php
│   │   ├── HomeController.php
│   │   ├── TemplateController.php
│   │   └── QRCodeController.php
│   ├── DataFixtures/
│   ├── Entity/
│   │   ├── Element.php
│   │   ├── Image.php
│   │   ├── Text.php
│   │   ├── Color.php
│   │   ├── Template.php
│   │   └── QrCode.php
│   ├── Form/
│   │   ├── ImageType.php
│   │   ├── TextType.php
│   │   ├── QRCodeType.php
│   │   ├── TemplateType.php
│   │   └── ElementType.php
│   ├── Repository/
│   ├── Service/
│   │   ├── ImageStorage.php
│   │   ├── QRCodeService.php
│   │   └── GoogleFontService.php
│   └── Kernel.php
├── templates/
│   ├── api/
│   │   └── template/
│   │       └── index.html.twig
│   ├── components/
│   ├── create_template/
│   │   ├── index.html.twig
│   │   └── success.html.twig
│   ├── element/
│   ├── fake_data/
│   │   └── index.html.twig
│   ├── form/
│   │   └── _form.html.twig
│   ├── home/
│   │   └── index.html.twig
│   ├── template/
│   │   └── index.html.twig
│   ├── base.html.twig
│   └── header.html.twig
├── translations/
├── var/
├── vendor/
├── test/
├── .env
├── .env.local
├── .gitignore
├── composer.json
├── phpunit.xml.dist
├── README.md
└── symfony.lock

```