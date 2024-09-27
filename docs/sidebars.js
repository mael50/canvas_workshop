/**
 * Creating a sidebar enables you to:
 - create an ordered group of docs
 - render a sidebar for each doc of that group
 - provide next/previous navigation

 The sidebars can be generated from the filesystem, or explicitly defined here.

 Create as many sidebars as you want.
 */

// @ts-check

// @ts-check


/**
 * Generates paths for the sidebar items.
 * @param {string} basePath
 * @param {string[]} files
 * @returns {string[]}
 */
const generatePaths = (basePath, files) => files.map(file => `${basePath}/${file}`);

/** @type {import('@docusaurus/plugin-content-docs').SidebarsConfig} */
const sidebars = {
  docTechniqueSidebar: [
    {
      type: 'category',
      label: 'Introduction',
      items: generatePaths('DocTechnique/Introduction', ['index', 'overview']),
    },
    {
      type: 'category',
      label: 'Architecture',
      items: generatePaths('DocTechnique/Architecture', ['index', 'stacks']),
    },
    {
      type: 'category',
      label: 'Conception Technique',
      items: generatePaths('DocTechnique/Conception', ['index', 'api', 'data-model']),
    },
    {
      type: 'category',
      label: 'Développement Technique',
      items: generatePaths('DocTechnique/Frontend', ['index', 'state', 'ui-ux']),
    }
  ],
  docUserSidebar: [
    {
      type: 'category',
      label: 'Introduction',
      items: generatePaths('DocUtilisateur/Introduction', ['index']),
    },
    {
      type: 'category',
      label: 'Prise en main de l\'interface',
      items: generatePaths('DocUtilisateur/PriseEnMain', ['index', 'gestion-des-elements']),
    },
    {
      type: 'category',
      label: 'Formulaires dynamiques',
      items: generatePaths('DocUtilisateur/DynamicForm', ['index']),
    },
    {
      type: 'category',
      label: 'Prévisualisation du template',
      items: generatePaths('DocUtilisateur/TemplatePreview', ['index']),
    }
  ]
};

export default sidebars;

