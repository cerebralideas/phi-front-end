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
			main: {
				src: 'src/js/*.js',
				dest: 'dev/js/main.js'
			}
		},
		min: {
			dist: {
				src: '',
				dest: ''
			}
		},
		test: {},
		watch: {
			js: {
				files: '<%= jshint.files %>',
				tasks: ['jshint', 'concat', 'macreload']
			},
			scss: {
				files: 'src/**/*.scss',
				tasks: ['compass:dev', 'macreload']
			}
		},
		jshint: {
			files: [
				'Gruntfile.js',
				'src/**/*.js'
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
				src: ['**/*.js'], // Actual pattern(s) to match.
				dest: 'dist/',    // Destination path prefix.
				ext: '.js',       // Dest filepaths will have this extension.
				flatten: false    // Remove directory structure in destination
			}
		},
		compass: {
			prod: {
				options: {
					sassDir: 'src/sass',
					cssDir: 'dist/',
					environment: 'production'
				}
			},
			dev: {
				options: {
					sassDir: 'src/sass',
					cssDir: 'dev/css/'
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
	grunt.registerTask('default', ['jshint', 'concat', 'compass:dev', 'macreload']);

	// Production build task.
	grunt.registerTask('build', ['lint', 'concat', 'uglify', 'compass-clean', 'compass:prod', 'macreload']);

};
