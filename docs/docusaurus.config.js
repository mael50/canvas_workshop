// docusaurus.config.js
import { themes as prismThemes } from 'prism-react-renderer';

/** @type {import('@docusaurus/types').Config} */
const config = {
  title: 'Docs My Vector Canvas',
  tagline: 'A website for my Vector Canvas',
  favicon: 'img/favicon.ico',

  url: 'http://localhost:8000',
  baseUrl: '/',

  projectName: 'canvas_workshop',

  onBrokenLinks: 'throw',
  onBrokenMarkdownLinks: 'warn',

  i18n: {
    defaultLocale: 'en',
    locales: ['en'],
  },

  markdown: {
    mermaid: true,
  },
  themes: ['@docusaurus/theme-mermaid'],

  presets: [
    [
      'classic',
      /** @type {import('@docusaurus/preset-classic').Options} */
      ({
        docs: {
          sidebarPath: require.resolve('./sidebars.js'),
        },
        theme: {
          customCss: require.resolve('./src/css/custom.css'),
        },
      }),
    ],
  ],

  themeConfig:
    /** @type {import('@docusaurus/preset-classic').ThemeConfig} */
    ({
      image: 'img/docusaurus-social-card.jpg',
      navbar: {
        logo: {
          alt: 'My Vector Canvas Logo',
          src: 'img/logo.png',
        },
        items: [
          {
            type: 'docSidebar',
            sidebarId: 'docTechniqueSidebar',
            position: 'left',
            label: 'Documentation Technique',
          },
          {
            type: 'docSidebar',
            sidebarId: 'docUserSidebar',
            position: 'left',
            label: 'Documentation Utilisateur',
          },
        ],
      },
      footer: {
        links: [
          {
            title: 'Documentation Technique',
            items: [
              {
                label: 'Introduction',
                to: '/docs/DocTechnique/Introduction/index',
              },
            ],
          },
          {
            title: 'Documentation Utilisateur',
            items: [
              {
                label: 'Introduction',
                to: '/docs/DocUtilisateur/Introduction/index',
              },
            ],
          },
        ],
        copyright: `Copyright © ${new Date().getFullYear()} My Vector Canvas.`,
      },
      prism: {
        theme: prismThemes.github,
        darkTheme: prismThemes.dracula,
      },
    }),
};

export default config;