/*global module:false*/
module.exports = function(grunt) {

	"use strict";

	// Project configuration.
	grunt.initConfig({

		pkg: grunt.file.readJSON('package.json'),
		concat: {
			options: {
				banner: '/*! <%= pkg.name %> | Version: <%= pkg.version %> | ' +
						'Concatenated on <%= grunt.template.today("yyyy-mm-dd") %> */\n\n',
				separator: '\n\n;// End of file\n\n'
			},
			main: {}
		},
		test: {},
		watch: {
			js: {
				files: '<%= jshint.files %>',
				tasks: ['macreload']
			},
			scss: {
				files: ['main.scss', 'framework/**/*.scss'],
				tasks: ['compass:dev', 'macreload']
			}
		},
		jshint: {
			files: [
				'Gruntfile.js',
				'framework/**/*.js',
				'main.js'
			],
			options: {
				jshintrc: '.jshintrc' // Retrieves .jshintrc file from public/ See jshintrcExplained.js for more details
			}
		},
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> | Version: <%= pkg.version %> | ' +
						'Minified on <%= grunt.template.today("yyyy-mm-dd") %> */\n\n'
			},
			build: {
				expand: true,     // Enable dynamic expansion.
				cwd: 'dev/',      // Src matches are relative to this path.
				src: ['main.js', 'framework/**/*.js'], // Actual pattern(s) to match.
				dest: 'dist/',    // Destination path prefix.
				ext: '.js',       // Dest filepaths will have this extension.
				flatten: false    // Remove directory structure in destination
			}
		},
		compass: {
			dev: {
				options: {
					sassDir: '',
					cssDir: 'demo-css/'
				}
			}
		},
		macreload: {
			reload: {
				browser: 'canary'
			}
		}
	});

	// Load in contrib tasks
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-htmlmin');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');

	// Load the "Live Reload" alternative
	grunt.loadNpmTasks('grunt-macreload');

	// Default dev tasks for grunt.
	grunt.registerTask('default', ['compass:dev', 'macreload']);

};
