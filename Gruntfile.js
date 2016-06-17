module.exports = function(grunt) {

  grunt.initConfig({
    pot: {
      options: {
        text_domain: 'infoamazonia',
        language: 'PHP',
        keywords: [
          '__',
          '_e',
          '_x:1,2c',
          '_ex:1,2c',
          '_n:1,2',
          '_nx:1,2,4c'
        ],
        dest: 'languages/'
      },
      files: {
        src: ['**/*.php', '!node_modules/**/*.php', '!inc/acf/**/*.php', '!lib/**/*.php'],
        expand: true
      }
    }
  });

  grunt.loadNpmTasks('grunt-pot');

  grunt.registerTask(
    'default',
    ['pot']
  );

}
