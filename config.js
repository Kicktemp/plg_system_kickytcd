import {createRequire} from "module";
import {extend} from "./scripts/tasks/util.js";

// Access package.json in ESM context
const require = createRequire(import.meta.url);
export const pjson = require('./package.json');

// Central build configuration used by scripts in scripts/tasks/*
// Notes:
// - Each path system (copy, release, package) can define multiple entries; all will be processed/watched.
// - The watch system uses KICK_CONFIG to pick a set (e.g., copy, release) and will watch all entries in that set.
// - replaceGlob defines which files will get placeholder replacement using stringsreplace.
export const config = {
  paths: {
    // Default development copy targets. Multiple destinations supported.
    copy: [
      {
        casesensitive: false, // apply case-sensitive path replacements if configured in package.json.casesensitive
        src: 'src/structure/',
        glob: 'src/structure/**/**', // which files to consider
        replaceGlob: 'src/structure/**/**.{php,html,xml,php,ini,less,json,js,css}', // which files receive placeholder replacement
        dest: 'dist5/', // local Joomla instance path
      }
    ],
    // Prepare files for release packaging
    release: [
      {
        src: 'src/structure/',
        glob: 'src/structure/**/**',
        replaceGlob: 'src/structure/**/**.{php,html,xml,php,ini,less,json,js,css}',
        dest: 'releasefiles/',
      }
    ],
    // Copy from releasefiles into sourcefiles structure for archiving
    package: [
      {
        src: 'releasefiles/plugins/system/kickytcd/',
        glob: 'releasefiles/plugins/system/kickytcd/**/**',
        dest: 'sourcefiles/plg_system_kickytcd/'
      }
    ],
    // Paths removed by cleaner
    cleaner: [
      'releasefiles/',
      'sourcefiles/',
      'archives/',
      'package/'
    ],
    // Update XML generation/backup locations
    updateXML: {
      src: 'update.xml',        // main update XML which will be re-written
      rename: 'oldupdate.xml',  // backup of previous update.xml
      template: 'updatetemplate.xml', // template containing a fresh <update> node
      dest: './'
    },
  },
  // Archive build configuration
  archiver: [
    {
      destination : 'archives/',
      name: 'plg_system_kickytcd',
      suffixversion: true, // append package.json version to archive name
      types: [
        {
          extension: '.zip',
          type: 'zip',
          options: {
            zlib: { 'level': 9 }
          }
        }
      ],
      folders: [
        'sourcefiles/plg_system_kickytcd'
      ],
      files: [
        // Additional single files can be added here if needed
      ]
    }
  ]
};

// Strings used for placeholder replacement in copy/copyrelease systems
export const stringsreplace = extend({}, {"[VERSION]": pjson.version}, pjson.placeholder);
