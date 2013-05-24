/*global module:false*/
module.exports = function(grunt) {

	"use strict";

	// Project configuration.
	grunt.initConfig({

		pkg: grunt.file.readJSON('package.json'),
		lint: {
			files: [
				'Gruntfile.js',
				'test/**/*.js',
				'src/js/*.js',
				'src/js/**/*.js'
			]
		},
		concat: {
			main: {
				src: 'src/js/main.js',
				dest: 'dev/js/main.js',
				separator: '\n\n;// End file\n\n'
			}
		},
		min: {
			dist: {
				src: '',
				dest: ''
			}
		},
		markdown: {
			all: {
				files: 'docs/md/*',
				dest: 'docs/html/',
				template: 'templates/markdown/html-partial-template.html'
			}
		},
		test: {
			unit: ['test/spec/**/*.js']
		},
		watch: {
			files: [
				'<%= lint.files %>',
				'phi/ui-ix/*.scss',
				'phi/ui-ix/core/**/*.scss',
				'phi/ui-ix/extensions/**/*.scss',
				'src/sass/*.scss'
			],
			tasks: 'default'
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
				PHI: true,
				Modernizr: true,
				angular: true,
				require: true,
				define: true
			}
		},
		uglify: {},
		compass: {
			prod: {
				options: {
					sassDir: 'src/sass',
					cssDir: 'dist/css',
					environment: 'production'
				}
			},
			dev: {
				options: {
					sassDir: 'src/sass',
					cssDir: 'dev/css'
				}
			}
		},
		macreload: {
			reload: {
				browser: 'canary'
			}
		}
	});

	// Load in contrib task suite
	grunt.loadNpmTasks('grunt-contrib');

	// Load in Markdown task
	grunt.loadNpmTasks('grunt-markdown');

	// A Live Reload alternative
	grunt.loadNpmTasks('grunt-macreload');

	// Default dev tasks for grunt.
	grunt.registerTask('default', ['lint', 'concat', 'compass:dev', 'macreload']);

	// Production build task.
	grunt.registerTask('build', ['lint', 'concat', 'markdown', 'min', 'compass-clean', 'compass:prod', 'macreload']);

};
