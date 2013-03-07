/*global module:false*/
module.exports = function(grunt) {

    "use strict";

    // Project configuration.
    grunt.initConfig({
        pkg: '<json:package.json>',
        meta: {
            name: '<%= pkg.name %>',
            version: '<%= pkg.version %>'
        },
        lint: {
            files: [
                'grunt.js',
                'js/*.js',
                'js/plugins-custom/*.js',
                'js/controllers/*.js',
                'js/directives/*.js',
                'js/services/*.js'
            ]
        },
        less: {
            "css/grunt-style.css": 'less/style.less',
            "css/grunt-print.css": 'less/print.less'
        },
        concat: {
            thirdparty: {
                src: 'js/plugins-thirdparty/*.js',
                dest: 'js/plugins-thirdparty/dev/thirdparty.concat.js',
                separator: '\n\n;// End file\n\n'
            },
            custom: {
                src: 'js/plugins-custom/*.js',
                dest: 'js/plugins-custom/dev/custom.concat.js',
                separator: '\n\n;// End file\n\n'
            },
            appt: {
                src: 'temp/appointments/*.json',
                dest: 'temp/concat/appts.concat.json',
                separator: '\n\n;// End file\n\n'
            },
            adm: {
                src: 'temp/admissions/*.json',
                dest: 'temp/concat/adms.concat.json',
                separator: '\n\n;// End file\n\n'
            }
        },
        docs: {
            md: {
                src: ['docs/md/*'],
                dest: 'docs/html/'
            }
        },
        test: {
            unit: ['test/spec/**/*.js']
        },
        watch: {
            files: [
                '<config:lint.files>',
                'less/*.less',
                'less/bootstrap/*.less'
            ],
            tasks: 'lint less concat'
        },
        jshint: {
            options: {
                curly: true,
                eqeqeq: true,
                immed: true,
                latedef: true,
                newcap: true,
                noarg: true,
                sub: true,
                undef: true,
                boss: true,
                eqnull: true,
                strict: true,
                devel: true,
                browser: true
            },
            globals: {
                jQuery: true,
                $: true,
                PAS: true,
                DATA: true,
                Modernizr: true,
                angular: true,
                require: true
            }
        },
        uglify: {}
    });

    // Load in less compile task for
    grunt.loadNpmTasks('grunt-contrib');

    // Load in docs task to build README and status updates file
    grunt.loadNpmTasks('grunt-docs');

    // Alias the `test` task to run `testacular` instead
    grunt.registerTask('test', 'run the testacular test driver', function () {

        var done = this.async();

        require('child_process').exec('testacular start --single-run', function (err, stdout) {
            grunt.log.write(stdout);
            done(err);
        });
    });

    // Default tasks for grunt.
    grunt.registerTask('default', 'lint less concat');

};
