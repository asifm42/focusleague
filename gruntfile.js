module.exports = function (grunt) {
    'use strict';
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // @see https://www.npmjs.com/package/grunt-contrib-copy
        copy: {
            bootswatch: {
                files: [
                    {
                        cwd: 'bower_components/bootswatch-dist/',
                        // src: ['css/**','fonts/**','js/**'],
                        src: ['fonts/**'],
                        dest: 'public/assets/',
                        expand: true
                    }
                ]
            },
            fontawesome: {
                files: [
                    {
                        cwd: 'bower_components/fontawesome/',
                        // src: ['css/**','fonts/**'],
                        src: ['fonts/**'],
                        dest: 'public/assets/',
                        expand: true
                    }
                ]
            }// ,
            // jquery: {
            //     files: [
            //         {
            //             cwd: 'bower_components/jquery/dist/',
            //             src: ['**'],
            //             dest: 'public/assets/js/',
            //             expand: true
            //         },
            //     ]
            // }
        },

        // @see https://www.npmjs.org/package/grunt-contrib-concat
        concat: {
            sitejs: {
                files: {
                    'public/assets/js/site.js': [
                        'bower_components/jquery/dist/jquery.js',
                        'bower_components/moment/moment.js',
                        'bower_components/bootswatch-dist/js/bootstrap.js',
                        'bower_components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js',
                        'bower_components/typeahead.js/dist/typeahead.bundle.js'
                        // 'bower_components/jquery-popupwindow/jquery.popupwindow.js',
                        // 'bower_components/underscore/underscore.js',
                        // 'bower_components/underscore.string/dist/underscore.string.js',
                    ]
                }
            },
            sitecss: {
                files: {
                    'public/assets/css/site.css': [
                        'bower_components/bootswatch-dist/css/bootstrap.css',
                        'bower_components/fontawesome/css/font-awesome.css',
                        'bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css',
                        'public/assets/css/default.css'
                    ]
                }
            }

        },

        // @see https://www.npmjs.com/package/grunt-contrib-cssmin
        cssmin: {
            options: {
                keepBreaks: true,
                keepSpecialComments: 0
            },
            site: {
                files: {
                    'public/assets/css/site.min.css': [
                        'public/assets/css/site.css'
                    ]
                }
            }
        },

        // @see https://www.npmjs.org/package/grunt-contrib-uglify
        uglify : {
            options: {
                compress: {
                    drop_console: true,
                    drop_debugger: true
                }
            },
            site: {
                src: 'public/assets/js/site.js',
                dest: 'public/assets/js/site.min.js'
            }
        }
    });

    // Load plugins.
    // @see http://gruntjs.com/getting-started#loading-grunt-plugins-and-tasks
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // Register tasks.
    // @see http://gruntjs.com/getting-started#loading-grunt-plugins-and-tasks
    grunt.registerTask('default', ['copy','concat', 'cssmin', 'uglify']);
};
