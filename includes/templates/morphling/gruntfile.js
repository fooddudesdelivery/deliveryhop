module.exports = function(grunt) {

 var config = {
    author: "Numinix",
    webRoot: ''
  }; //config

  grunt.initConfig({
    jshint: {
        options: {
          browser: true,
          boss: true
        }, //options
        gruntfile: {
          src: ['gruntfile.js']
        } //gruntfile
    },

    compass: {
      dev: {
        options: {
          sassDir: config.webRoot + 'scss',
          cssDir: config.webRoot + 'css',
          force: true,
          noLineComments: false,
          environment: 'development',
          outputStyle: 'expanded'
        } //options
      }, //dev
      release: {
        options: {
          sassDir: config.webRoot + 'scss',
          cssDir: config.webRoot + 'css',
          force: true,
          noLineComments: true,
          environment: 'production',
          outputStyle: 'compressed'
        } //options
      } //release
    },

    watch: {
      options: { livereload: true },
      scripts: {
        files: ['jscript/**'],
      }, //scripts
      php: {
        files: ['templates/**', 'common/**']
      }, //php
      sass: {
        files: ['scss/**'],
        tasks: ['compass:dev']
      } //sass
    } //watch
  }); //grunt.initConfig


  // Load the plugins
  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

  // Default task(s).
  grunt.registerTask('default', ['jshint:gruntfile']);
  grunt.registerTask('deploy', ['jshint', 'compass:release']);
  grunt.registerTask('listen', ['jshint:gruntfile', 'watch']);

};